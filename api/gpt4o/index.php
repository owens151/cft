<?php
header('Content-Type: application/json');

// Lokasi file API Key (path absolut)
$key_file = $_SERVER['DOCUMENT_ROOT'] . "/api/keyy.txt";

// Periksa apakah file API Key ada
if (!file_exists($key_file)) {
    echo json_encode(["status" => 500, "message" => "Error!"], JSON_PRETTY_PRINT);
    exit;
}

// Ambil API Key dari file
$valid_apikey = trim(file_get_contents($key_file));

// Redirect jika tidak ada parameter
if (!isset($_GET['q']) || !isset($_GET['apikey'])) {
    header("Location: ?q=&apikey=");
    exit;
}

// Cek API Key
$apikey = $_GET['apikey'];
if ($apikey !== $valid_apikey) {
    echo json_encode(["status" => 403, "message" => "API Key tidak valid"], JSON_PRETTY_PRINT);
    exit;
}

// Cek apakah parameter 'q' tersedia
$q = $_GET['q'];
if (empty($q)) {
    echo json_encode(["status" => 400, "message" => "Parameter 'q' tidak boleh kosong"], JSON_PRETTY_PRINT);
    exit;
}

// URL API sumber
$api_url = "https://vapis.my.id/api/gpt4o?q=" . urlencode($q);

// Ambil data dari API sumber
$response = file_get_contents($api_url);

if ($response === false) {
    echo json_encode(["status" => 500, "message" => "Error!"], JSON_PRETTY_PRINT);
    exit;
}

$data = json_decode($response, true);

if (!$data || !isset($data['status'], $data['result'])) {
    echo json_encode(["status" => 500, "message" => "Error!"], JSON_PRETTY_PRINT);
    exit;
}

// Tambahkan informasi creator dan developer di bawah status
$result = [
    "status" => $data['status'],
    "creator" => "hanlala.in",
    "developer" => "@owensdev || 6285358977442",
    "result" => $data['result']
];

// Tampilkan hasil JSON
echo json_encode($result, JSON_PRETTY_PRINT);
?>