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
if (!isset($_GET['query']) || !isset($_GET['apikey'])) {
    header("Location: ?query=&apikey=");
    exit;
}

// Cek API Key
$apikey = $_GET['apikey'];
if ($apikey !== $valid_apikey) {
    echo json_encode(["status" => 403, "message" => "API Key tidak valid"], JSON_PRETTY_PRINT);
    exit;
}

// Cek apakah query tersedia
$query = $_GET['query'];
if (empty($query)) {
    echo json_encode(["status" => 400, "message" => "Query tidak valid"], JSON_PRETTY_PRINT);
    exit;
}

// URL API sumber
$api_url = "https://api.vreden.my.id/api/spotifysearch?query=" . urlencode($query);

// Ambil data dari API sumber
$response = file_get_contents($api_url);

if ($response === false) {
    echo json_encode(["status" => 500, "message" => "Error!"], JSON_PRETTY_PRINT);
    exit;
}

$data = json_decode($response, true);

if (!$data || !isset($data['result'])) {
    echo json_encode(["status" => 500, "message" => "Error!"], JSON_PRETTY_PRINT);
    exit;
}

// Modifikasi data dan menambahkan creator & developer
$response_data = [
    "status" => 200,
    "creator" => "hanlala.in",
    "developer" => "@owensdev || 6285358977442",
    "result" => $data['result'] // Menambahkan result dari API sumber
];

// Tampilkan hasil JSON
echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>