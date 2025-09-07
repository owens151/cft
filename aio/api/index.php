<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

class MediaDownloaderAPI {
    private $primaryApiUrl = 'https://izumiiiiiiii.dpdns.org/downloader/aio';
    private $fallbackApiUrl = 'https://api.ryzumi.vip/api/downloader/aiodown';
    private $validApiKey = 'aiokey151';
    
    public function handleRequest() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
                throw new Exception('Service temporarily unavailable', 405);
            }
            
            // Validasi API Key
            $apiKey = isset($_GET['key']) ? trim($_GET['key']) : '';
            
            if (empty($apiKey)) {
                throw new Exception('Authentication required', 400);
            }
            
            if ($apiKey !== $this->validApiKey) {
                throw new Exception('Access denied', 401);
            }
            
            // Validasi URL
            $url = isset($_GET['url']) ? trim($_GET['url']) : '';
            
            if (empty($url)) {
                throw new Exception('Missing required parameter', 400);
            }
            
            if (!$this->isValidUrl($url)) {
                throw new Exception('Invalid request format', 400);
            }
            
            $result = $this->downloadMedia($url);
            
            $this->sendResponse([
                'success' => true,
                'data' => $result['data'],
                'api_used' => $result['api_used'],
                'count' => count($result['data'])
            ]);
            
        } catch (Exception $e) {
            $this->sendError($e->getMessage(), $e->getCode() ?: 500);
        }
    }
    
    private function downloadMedia($url) {
        $data = null;
        $apiUsed = 'Primary';
        
        try {
            // Try primary API first
            $apiUrl = $this->primaryApiUrl . '?url=' . urlencode($url);
            $data = $this->tryApiRequest($apiUrl, true);
        } catch (Exception $e) {
            // Fallback to secondary API
            try {
                $fallbackApiUrl = $this->fallbackApiUrl . '?url=' . urlencode($url);
                $data = $this->tryApiRequest($fallbackApiUrl, false);
                $apiUsed = 'Fallback';
            } catch (Exception $fallbackError) {
                throw new Exception('Connection timeout');
            }
        }
        
        if (empty($data)) {
            throw new Exception('Content not found');
        }
        
        return [
            'data' => $data,
            'api_used' => $apiUsed
        ];
    }
    
    private function tryApiRequest($apiUrl, $isFallback = false) {
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'timeout' => 30,
                'user_agent' => 'MediaDownloader/1.0'
            ]
        ]);
        
        $response = @file_get_contents($apiUrl, false, $context);
        
        if ($response === false) {
            throw new Exception('Network error');
        }
        
        $data = json_decode($response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Server error');
        }
        
        if ($isFallback) {
            if (!isset($data['status']) || !isset($data['result'])) {
                throw new Exception('Data not available');
            }
            return $this->convertApi2ToApi1Format($data);
        } else {
            if (!is_array($data) || empty($data)) {
                throw new Exception('Content not found');
            }
            return $data;
        }
    }
    
    private function convertApi2ToApi1Format($api2Data) {
        if (!isset($api2Data['result']) || !isset($api2Data['result']['medias'])) {
            return [];
        }
        
        $result = $api2Data['result'];
        $medias = $result['medias'];
        
        $videoMedias = array_filter($medias, function($media) {
            return isset($media['type']) && $media['type'] === 'video';
        });
        
        $audioMedias = array_filter($medias, function($media) {
            return isset($media['type']) && $media['type'] === 'audio';
        });
        
        $bestVideo = null;
        foreach ($videoMedias as $media) {
            if (!$bestVideo || ($media['bitrate'] ?? 0) > ($bestVideo['bitrate'] ?? 0)) {
                $bestVideo = $media;
            }
        }
        
        $bestAudio = null;
        foreach ($audioMedias as $media) {
            if (!$bestAudio || ($media['bitrate'] ?? 0) > ($bestAudio['bitrate'] ?? 0)) {
                $bestAudio = $media;
            }
        }
        
        return [[
            'title' => $result['title'] ?? 'Unknown Title',
            'thumbnail' => $result['thumbnail'] ?? '',
            'video' => $bestVideo['url'] ?? '',
            'audio' => $bestAudio['url'] ?? '',
            'duration' => $result['duration'] ?? 0,
            'source' => $result['source'] ?? 'unknown'
        ]];
    }
    
    private function isValidUrl($url) {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }
    
    private function sendResponse($data, $statusCode = 200) {
        http_response_code($statusCode);
        echo json_encode($data, JSON_PRETTY_PRINT);
        exit();
    }
    
    private function sendError($message, $statusCode = 500) {
        http_response_code($statusCode);
        echo json_encode([
            'success' => false,
            'error' => $message,
            'code' => $statusCode
        ], JSON_PRETTY_PRINT);
        exit();
    }
}

// Initialize and handle request
$api = new MediaDownloaderAPI();
$api->handleRequest();
?>