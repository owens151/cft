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
if (!isset($_GET['url']) || !isset($_GET['apikey'])) {
    header("Location: ?url=&apikey=");
    exit;
}

// Cek API Key
$apikey = $_GET['apikey'];
if ($apikey !== $valid_apikey) {
    echo json_encode(["status" => 403, "message" => "API Key tidak valid"], JSON_PRETTY_PRINT);
    exit;
}

// Cek apakah URL tersedia
$url = $_GET['url'];
if (empty($url)) {
    echo json_encode(["status" => 400, "message" => "Url tidak valid"], JSON_PRETTY_PRINT);
    exit;
}

// URL API sumber
$api_url = "https://api.vreden.my.id/api/igdownload?url=" . urlencode($url);

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

// Tambahkan creator di bawah status 200
if (isset($data['status']) && $data['status'] == 200) {
    $data['creator'] = "hanlala.in";
}

// Tambahkan creator di bawah "status": true dalam response
if (isset($data['result']['response']['status']) && $data['result']['response']['status'] === true) {
    $response_data = $data['result']['response'];

    // Simpan "status" dulu
    $new_response = ["status" => true];

    // Tambahkan "creator" di bawahnya
    $new_response["creator"] = "@owensdev || 6285358977442";

    // Gabungkan data lainnya tanpa status yang lama
    unset($response_data["status"]);
    $new_response = array_merge($new_response, $response_data);

    // Simpan perubahan
    $data['result']['response'] = $new_response;
}

// Tampilkan hasil JSON
echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>