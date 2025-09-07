<?php
$url = isset($_GET['url']) ? urlencode($_GET['url']) : '';

if (!$url) {
    echo "<h2>❌ URL tidak boleh kosong.</h2>";
    exit;
}

// Default server dan lokasi
$server = "server2";
$location = "uk";

// Endpoint API proxy
$api = "https://api.fasturl.link/tool/proxy?url={$url}&server={$server}&location={$location}";

// Ambil data HTML menggunakan cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    echo "<h2>🚫 Gagal mengambil konten: $error</h2>";
    exit;
}

// Tampilkan konten dari API (HTML)
echo $response;
?>