<?php
header('Content-Type: application/json');

// Lokasi file API Key (path absolut)
$key_file = $_SERVER['DOCUMENT_ROOT'] . "/api/keyy.txt";

// Periksa apakah file API Key ada
if (!file_exists($key_file)) {
    echo json_encode(["status" => 500, "message" => "Error!"], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    exit;
}

// Ambil API Key dari file
$valid_apikey = trim(file_get_contents($key_file));

// Redirect jika tidak ada parameter
if (!isset($_GET['teks']) || !isset($_GET['apikey'])) {
    header("Location: ?teks=&apikey=");
    exit;
}

// Cek API Key
$apikey = $_GET['apikey'];
if ($apikey !== $valid_apikey) {
    echo json_encode(["status" => 403, "message" => "API Key tidak valid"], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    exit;
}

// Cek apakah parameter teks tersedia
$teks = $_GET['teks'];
if (empty($teks)) {
    echo json_encode(["status" => 400, "message" => "Parameter 'teks' tidak valid"], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    exit;
}

// Pastikan folder tmp ada
$tmp_folder = $_SERVER['DOCUMENT_ROOT'] . "/tmp/";
if (!is_dir($tmp_folder)) {
    mkdir($tmp_folder, 0777, true);
}

// URL API sumber untuk mengambil foto
$api_url = "https://brat.caliphdev.com/api/brat?text=" . urlencode($teks);

// Ambil data dari API sumber
$photo_data = file_get_contents($api_url);

if ($photo_data === false) {
    echo json_encode(["status" => 500, "message" => "Error!"], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    exit;
}

// Simpan foto ke folder tmp
$filename = "photo_" . time() . ".jpg";
$file_path = $tmp_folder . $filename;
file_put_contents($file_path, $photo_data);

// Buat URL akses foto
$photo_url = "https://" . $_SERVER['HTTP_HOST'] . "/tmp/" . $filename;

// Tampilkan hasil JSON tanpa backslash dalam URL
echo json_encode([
    "status" => 200,
    "creator" => "hanlala.in",
    "developer" => "@owensdev || 6285358977442",
    "message" => "success",
    "photo_url" => $photo_url
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
?>