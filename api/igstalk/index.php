<?php
header('Content-Type: application/json');

// Lokasi file API Key (path absolut)
$file_key = $_SERVER['DOCUMENT_ROOT'] . "/api/keyy.txt";

// Periksa apakah file API Key ada
if (!file_exists($file_key)) {
    echo json_encode(["status" => 500, "message" => "Error!"], JSON_PRETTY_PRINT);
    exit;
}

// Ambil API Key dari file
$apikey_valid = trim(file_get_contents($file_key));

// Redirect jika tidak ada parameter
if (!isset($_GET['query']) || !isset($_GET['apikey'])) {
    header("Location: ?query=&apikey=");
    exit;
}

// Cek API Key
$apikey = $_GET['apikey'];
if ($apikey !== $apikey_valid) {
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
$api_url = "https://api.vreden.my.id/api/igstalk?query=" . urlencode($query);

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

// Menambahkan informasi pembuat di level utama (opsional)
$data['creator'] = "hanlala.in";

// Jika status bernilai true, tambahkan field creator di dalam result
if (isset($data['result']['status']) && $data['result']['status'] === true) {
    // Untuk memastikan urutan key, kita rekonstruksi array result
    $result = $data['result'];
    $result_terurut = [];

    // Pertama, masukkan key status
    $result_terurut['status'] = $result['status'];

    // Kedua, tambahkan creator tepat setelah status
    $result_terurut['creator'] = "@owensdev || 6285358977442";

    // Kemudian, masukkan key-key lainnya (selain status dan creator)
    foreach ($result as $key => $value) {
        if ($key !== 'status' && $key !== 'creator') {
            $result_terurut[$key] = $value;
        }
    }
    $data['result'] = $result_terurut;
}

// Tampilkan hasil JSON
echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>