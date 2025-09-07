<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>CFT API Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/ScrollTrigger.min.js"></script>
  <style>
    * {
      font-family: 'Poppins', sans-serif;
      scroll-behavior: smooth;
    }
    
    :root {
      --primary: #7c3aed;
      --primary-light: #a78bfa;
      --primary-dark: #6d28d9;
      --secondary: #ec4899;
      --tertiary: #34d399;
      --bg-dark: #0f172a;
      --bg-dark-light: #1e293b;
      --text-light: #e0e7ff;
      --text-muted: #94a3b8;
    }
    
    body {
      background: radial-gradient(circle at top right, var(--bg-dark-light), var(--bg-dark) 70%);
      color: var(--text-light);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 1rem;
      position: relative;
      overflow-x: hidden;
    }
    
    body::before {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%237c3aed' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
      z-index: -1;
    }
    
    .glass {
      background: rgba(31, 41, 55, 0.75);
      border: 1px solid rgba(255, 255, 255, 0.15);
      border-radius: 1.25rem;
      backdrop-filter: saturate(180%) blur(20px);
      padding: 1.75rem 2rem;
      box-shadow:
        0 4px 6px rgba(124, 58, 237, 0.3),
        0 1px 3px rgba(124, 58, 237, 0.2);
      transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.5s ease;
    }
    
    .glass:hover {
      transform: translateY(-8px) scale(1.02);
      box-shadow:
        0 15px 25px rgba(124, 58, 237, 0.4),
        0 10px 10px rgba(124, 58, 237, 0.2);
    }
    
    .glow-text {
      text-shadow: 0 0 15px rgba(124, 58, 237, 0.7);
    }
    
    .feature-icon {
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      border-radius: 50%;
      width: 56px;
      height: 56px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 1.5rem;
      box-shadow: 0 8px 20px rgba(124, 58, 237, 0.4);
      margin-bottom: 1rem;
    }
    
    .back-to-top {
      position: fixed;
      bottom: 30px;
      right: 30px;
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      padding: 16px;
      border-radius: 50%;
      cursor: pointer;
      opacity: 0;
      transition: all 0.4s ease;
      box-shadow: 
        0 8px 20px rgba(167, 139, 250, 0.6),
        0 0 0 5px rgba(167, 139, 250, 0.2);
      z-index: 999;
      color: white;
      font-size: 1.4rem;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    .back-to-top:hover {
      transform: translateY(-5px) scale(1.1);
      box-shadow: 
        0 12px 30px rgba(167, 139, 250, 0.9),
        0 0 0 8px rgba(167, 139, 250, 0.3);
    }
    
    .back-to-top.visible {
      opacity: 1;
      transform: translateY(0);
    }
    
    /* Curved section divider */
    .wave-divider {
      height: 150px;
      overflow: hidden;
      position: relative;
    }
    
    .wave-divider svg {
      position: absolute;
      bottom: 0;
      width: 100%;
      height: 100px;
    }
    
    /* Custom scrollbar */
    ::-webkit-scrollbar {
      width: 10px;
    }
    
    ::-webkit-scrollbar-track {
      background: rgba(31, 41, 55, 0.5);
    }
    
    ::-webkit-scrollbar-thumb {
      background: linear-gradient(to bottom, var(--primary-light), var(--primary));
      border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
      background: var(--primary);
    }
    
    /* Animated underline on hover */
    .hover-underline {
      position: relative;
      display: inline-block;
      padding-bottom: 2px;
    }
    
    .hover-underline::after {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      bottom: 0;
      left: 0;
      background: linear-gradient(to right, var(--primary), var(--secondary));
      transition: width 0.3s ease-in-out;
    }
    
    .hover-underline:hover::after {
      width: 100%;
    }
    
    /* Category badge */
    .category-badge {
      display: inline-flex;
      align-items: center;
      background: linear-gradient(135deg, var(--primary-dark), var(--primary));
      color: white;
      border-radius: 999px;
      padding: 0.5rem 1.25rem;
      font-weight: 600;
      font-size: 0.875rem;
      box-shadow: 0 4px 12px rgba(124, 58, 237, 0.4);
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
      z-index: 1;
    }
    
    .category-badge::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, var(--secondary), var(--primary));
      transition: left 0.4s ease-in-out;
      z-index: -1;
    }
    
    .category-badge:hover::before {
      left: 0;
    }
    
    .category-badge:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 15px rgba(124, 58, 237, 0.6);
    }
    
    /* Enhanced table styles */
    .api-table {
      border-collapse: separate;
      border-spacing: 0;
      border-radius: 1rem;
      overflow: hidden;
    }
    
    .api-table thead {
      background: linear-gradient(90deg, var(--primary-dark), var(--primary), var(--secondary));
    }
    
    .api-table th {
      padding: 1.25rem 1.5rem;
      color: white;
      font-weight: 600;
      letter-spacing: 0.05em;
      text-transform: uppercase;
      position: relative;
    }
    
    .api-table th:after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 4px;
      background: rgba(255, 255, 255, 0.15);
    }
    
    .api-table tbody tr {
      background: rgba(31, 41, 55, 0.4);
      transition: all 0.3s ease;
    }
    
    .api-table tbody tr:nth-child(odd) {
      background: rgba(31, 41, 55, 0.8);
    }
    
    .api-table tbody tr:hover {
      background: rgba(124, 58, 237, 0.2);
      transform: scale(1.02) translateX(5px);
      box-shadow: 0 5px 15px rgba(124, 58, 237, 0.3);
      z-index: 10;
    }
    
    .api-table td {
      padding: 1.25rem 1.5rem;
      border-bottom: 1px solid rgba(124, 58, 237, 0.2);
    }
    
    /* Button styles */
    .btn-primary {
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      color: white;
      border-radius: 999px;
      padding: 0.75rem 1.5rem;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(124, 58, 237, 0.4);
      position: relative;
      overflow: hidden;
      z-index: 1;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }
    
    .btn-primary::after {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, var(--secondary), var(--primary));
      transition: left 0.4s ease-in-out;
      z-index: -1;
    }
    
    .btn-primary:hover::after {
      left: 0;
    }
    
    .btn-primary:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(124, 58, 237, 0.6);
    }
    
    .btn-primary:active {
      transform: translateY(0);
    }
    
    .btn-success {
      background: linear-gradient(135deg, var(--tertiary), #10b981);
      color: white;
      border-radius: 999px;
      padding: 1rem 2rem;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(52, 211, 153, 0.4);
      display: inline-flex;
      align-items: center;
      gap: 0.75rem;
      position: relative;
      overflow: hidden;
      z-index: 1;
    }
    
    .btn-success::after {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, #10b981, var(--tertiary));
      transition: left 0.4s ease-in-out;
      z-index: -1;
    }
    
    .btn-success:hover::after {
      left: 0;
    }
    
    .btn-success:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(52, 211, 153, 0.6);
    }
    
    /* Feature cards */
    .feature-card {
      background: rgba(31, 41, 55, 0.7);
      border-radius: 1rem;
      padding: 2rem;
      border: 1px solid rgba(124, 58, 237, 0.2);
      transition: all 0.4s ease;
      height: 100%;
    }
    
    .feature-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 30px rgba(124, 58, 237, 0.3);
      border-color: rgba(124, 58, 237, 0.4);
      background: rgba(31, 41, 55, 0.9);
    }
    
    /* Search bar styles */
    .search-container {
      position: relative;
      margin-bottom: 3rem;
    }
    
    @keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}
.animate-fadeIn {
  animation: fadeIn 0.8s ease forwards;
  opacity: 0;
}
.animate-fadeIn.delay-100 { animation-delay: 0.1s; }
.animate-fadeIn.delay-200 { animation-delay: 0.2s; }
.animate-fadeIn.delay-300 { animation-delay: 0.3s; }
.animate-fadeIn.delay-400 { animation-delay: 0.4s; }
.animate-fadeIn.delay-500 { animation-delay: 0.5s; }
    
    .search-input {
      width: 100%;
      background: rgba(255, 255, 255, 0.07);
      border: 2px solid rgba(124, 58, 237, 0.3);
      border-radius: 999px;
      padding: 1.25rem 3.5rem;
      color: white;
      font-size: 1.125rem;
      font-weight: 500;
      transition: all 0.3s ease;
    }
    
    .search-input:focus {
      background: rgba(255, 255, 255, 0.1);
      border-color: var(--primary);
      box-shadow: 0 0 0 5px rgba(124, 58, 237, 0.2);
      outline: none;
    }
    
    .search-input::placeholder {
      color: var(--text-muted);
    }
    
    .search-icon {
      position: absolute;
      left: 1.25rem;
      top: 50%;
      transform: translateY(-50%);
      color: var(--primary-light);
      font-size: 1.25rem;
    }
    
    /* Pulse animation for search icon */
    @keyframes pulse {
      0% {
        transform: translateY(-50%) scale(1);
        opacity: 1;
      }
      50% {
        transform: translateY(-50%) scale(1.1);
        opacity: 0.8;
      }
      100% {
        transform: translateY(-50%) scale(1);
        opacity: 1;
      }
    }
    
    .search-input:focus + .search-icon {
      animation: pulse 1.5s infinite;
      color: var(--primary);
    }
    
    /* API count badge */
    .api-count {
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      color: white;
      border-radius: 999px;
      padding: 0.25rem 0.75rem;
      font-weight: 600;
      font-size: 0.875rem;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-left: 0.75rem;
    }
    
    /* Status indicator */
    .status-indicator {
      display: inline-block;
      width: 12px;
      height: 12px;
      border-radius: 50%;
      background: #10b981;
      margin-right: 0.5rem;
      position: relative;
    }
    
    .status-indicator::after {
      content: '';
      position: absolute;
      top: -4px;
      left: -4px;
      right: -4px;
      bottom: -4px;
      border-radius: 50%;
      background: rgba(16, 185, 129, 0.3);
      animation: ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;
    }
    
    @keyframes ping {
      75%, 100% {
        transform: scale(2);
        opacity: 0;
      }
    }
    
    /* Stat card */
    .stat-card {
      background: linear-gradient(135deg, rgba(124, 58, 237, 0.1), rgba(236, 72, 153, 0.1));
      border-radius: 1rem;
      padding: 1.5rem;
      border: 1px solid rgba(124, 58, 237, 0.2);
      position: relative;
      overflow: hidden;
      height: 100%;
    }
    
    .stat-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 4px;
      background: linear-gradient(to right, var(--primary), var(--secondary));
    }
    
    .stat-card-value {
      font-size: 2.5rem;
      font-weight: 700;
      color: white;
      margin-bottom: 0.5rem;
      background: linear-gradient(to right, var(--primary-light), var(--secondary));
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }
    
    /* Floating animation for decorative elements */
    @keyframes float {
      0% {
        transform: translateY(0px) rotate(0deg);
      }
      50% {
        transform: translateY(-15px) rotate(5deg);
      }
      100% {
        transform: translateY(0px) rotate(0deg);
      }
    }
    
    .floating {
      animation: float 6s ease-in-out infinite;
    }
    
    /* Card hover effect */
    .card-hover {
      transition: all 0.4s ease;
    }
    
    .card-hover:hover {
      transform: translateY(-8px);
      box-shadow: 0 15px 30px rgba(124, 58, 237, 0.3);
    }
    
    /* Hero text gradient */
    .hero-gradient-text {
      background: linear-gradient(to right, #ff4dc4, #a78bfa, #34d399);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      background-size: 200% auto;
      animation: textShine 5s linear infinite;
    }
    
    @keyframes textShine {
      to {
        background-position: 200% center;
      }
    }
    
    /* Loading spinner */
    .loader {
      width: 48px;
      height: 48px;
      border: 5px solid #FFF;
      border-bottom-color: var(--primary);
      border-radius: 50%;
      display: inline-block;
      box-sizing: border-box;
      animation: rotation 1s linear infinite;
    }
    
    @keyframes rotation {
      0% {
        transform: rotate(0deg);
      }
      100% {
        transform: rotate(360deg);
      }
    }
    
    /* Tooltip */
    .tooltip {
      position: relative;
      display: inline-block;
    }
    
    .tooltip .tooltip-text {
      visibility: hidden;
      width: 150px;
      background-color: var(--bg-dark);
      color: white;
      text-align: center;
      border-radius: 6px;
      padding: 0.5rem;
      font-size: 0.875rem;
      font-weight: 500;
      position: absolute;
      z-index: 100;
      bottom: 125%;
      left: 50%;
      transform: translateX(-50%);
      opacity: 0;
      transition: opacity 0.3s;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
      border: 1px solid rgba(124, 58, 237, 0.3);
    }
    
    .tooltip:hover .tooltip-text {
      visibility: visible;
      opacity: 1;
    }
    
    .tooltip .tooltip-text::after {
      content: "";
      position: absolute;
      top: 100%;
      left: 50%;
      margin-left: -5px;
      border-width: 5px;
      border-style: solid;
      border-color: var(--bg-dark) transparent transparent transparent;
    }
    
    /* Usage counter */
    .usage-counter {
      font-variant-numeric: tabular-nums;
      font-weight: 700;
      background: rgba(124, 58, 237, 0.1);
      padding: 0.25rem 0.75rem;
      border-radius: 999px;
      border: 1px solid rgba(124, 58, 237, 0.2);
      color: var(--primary-light);
    }
    
    /* Toast notification */
    .toast {
      position: fixed;
      top: 2rem;
      right: 2rem;
      background: rgba(31, 41, 55, 0.9);
      backdrop-filter: blur(10px);
      border-left: 4px solid var(--primary);
      padding: 1rem 1.5rem;
      border-radius: 0.5rem;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
      z-index: 9999;
      animation: slideIn 0.5s forwards, fadeOut 0.5s 3s forwards;
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }
    
    @keyframes slideIn {
      from {
        transform: translateX(100%);
        opacity: 0;
      }
      to {
        transform: translateX(0);
        opacity: 1;
      }
    }
    
    @keyframes fadeOut {
      from {
        opacity: 1;
      }
      to {
        opacity: 0;
        visibility: hidden;
      }
    }
    
    /* Mobile styles */
    @media (max-width: 768px) {
      .glass {
        padding: 1.25rem;
      }
      
      .api-table th, .api-table td {
        padding: 1rem;
      }
      
      .search-input {
        padding: 1rem 3rem;
      }
      
      .feature-icon {
        width: 48px;
        height: 48px;
        font-size: 1.25rem;
      }
      
      .stat-card-value {
        font-size: 2rem;
      }
      
      .back-to-top {
        bottom: 20px;
        right: 20px;
        padding: 12px;
        font-size: 1.25rem;
      }
    }
  </style>
</head>
<body>
<?php
$api_base = "/api";

// API data dengan informasi tambahan
$apis = [
    "AI" => [
        ["name" => "gpt4o", "slug" => "gpt4o", "desc" => "GPT-4o API untuk AI generatif", "usage" => 8721]
    ],
    "Downloader" => [
        ["name" => "facebook", "slug" => "fbdl", "desc" => "Download video dari Facebook", "usage" => 5430],
        ["name" => "instagram", "slug" => "igdl", "desc" => "Download foto & video Instagram", "usage" => 9845],
        ["name" => "spotify", "slug" => "spotify", "desc" => "Download lagu dari Spotify", "usage" => 7629],
        ["name" => "tiktok", "slug" => "ttdl", "desc" => "Download video TikTok tanpa watermark", "usage" => 12453],
        ["name" => "ytmp3", "slug" => "ytmp3", "desc" => "Convert YouTube ke MP3", "usage" => 15890],
        ["name" => "ytmp4", "slug" => "ytmp4", "desc" => "Download video YouTube", "usage" => 14378]
    ],
    "Searching" => [
        ["name" => "spotify", "slug" => "spotifysearch", "desc" => "Pencarian musik di Spotify", "usage" => 4271]
    ],
    "Stalker" => [
        ["name" => "instagram", "slug" => "igstalk", "desc" => "Lihat info profil Instagram", "usage" => 6843]
    ],
    "Tools" => [
        ["name" => "bratft", "slug" => "bratft", "desc" => "Transfer tools", "usage" => 3219],
        ["name" => "bratvid", "slug" => "bratvid", "desc" => "Video processing tools", "usage" => 4127]
    ]
];

// Hitung total API dan total penggunaan
$totalApis = 0;
$totalUsage = 0;

foreach ($apis as $category => $api_list) {
    $totalApis += count($api_list);
    foreach ($api_list as $api) {
        $totalUsage += $api['usage'];
    }
}
?>

  <!-- Toast notification container -->
  <div id="toast" class="toast" style="display: none;">
    <i class="fas fa-check-circle text-green-400 text-xl"></i>
    <div>
      <p class="font-medium">Berhasil!</p>
      <p class="text-sm text-gray-300">API berhasil dibuka di tab baru.</p>
    </div>
  </div>

  <!-- Decorative elements -->
  <div class="absolute top-40 right-10 opacity-20 floating" style="animation-delay: 1s; z-index: -1;">
    <i class="fas fa-rocket text-purple-400 text-9xl"></i>
  </div>
  <div class="absolute bottom-40 left-10 opacity-20 floating" style="animation-delay: 2s; z-index: -1;">
    <i class="fas fa-code text-pink-400 text-9xl"></i>
  </div>

  <div class="max-w-6xl mx-auto px-6 py-12 sm:py-20 relative">
    <!-- Main Content -->
    <header class="text-center mb-20 animate__animated animate__fadeInDown">
      <div class="inline-block p-2 px-4 bg-purple-900 bg-opacity-30 rounded-full mb-4 border border-purple-500">
        <span class="status-indicator"></span>
        <span class="text-sm font-medium">All Systems Operational</span>
      </div>
      
      <h1 class="text-6xl md:text-7xl font-extrabold mb-6 tracking-tight hero-gradient-text flex justify-center items-center gap-4 select-none">
        <span class="header-icon flex">🚀</span> API Dashboard
      </h1>
      
      <p class="text-gray-300 text-xl max-w-3xl mx-auto mb-8 font-medium">Platform API terlengkap dan terpercaya untuk kebutuhan pengembangan aplikasi Anda</p>
      
      <div class="flex flex-wrap justify-center gap-4 mb-10">
        <a href="https://wa.me/6285358977442" target="_blank" rel="noopener" class="btn-primary group">
          <i class="fab fa-whatsapp text-xl"></i> Hubungi via WhatsApp
          <i class="fas fa-arrow-right opacity-0 -translate-x-3 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300"></i>
        </a>
        
        <a href="#features" class="px-8 py-4 rounded-full border-2 border-purple-500 text-white hover:bg-purple-500 hover:bg-opacity-20 transition-all duration-300 font-semibold flex items-center gap-2">
          <i class="fas fa-info-circle"></i> Pelajari Lebih Lanjut
        </a>
      </div>
      
      <div class="flex flex-wrap justify-center gap-8 mt-12">
        <div class="stat-card text-center px-6 py-4">
          <div class="stat-card-value animate__animated animate__fadeIn" id="apiCounter">0</div>
          <p class="text-gray-300 font-medium">Total API</p>
        </div>
        
        <div class="stat-card text-center px-6 py-4">
          <div class="stat-card-value animate__animated animate__fadeIn" id="usageCounter">0</div>
          <p class="text-gray-300 font-medium">Total Penggunaan</p>
        </div>
        
        <div class="stat-card text-center px-6 py-4">
          <div class="stat-card-value animate__animated animate__fadeIn">99.9%</div>
          <p class="text-gray-300 font-medium">Uptime</p>
        </div>
      </div>
    </header>

    <!-- Features Section -->
    <section id="features" class="mb-20">
      <div class="text-center mb-12">
        <h2 class="text-4xl font-extrabold mb-4 glow-text">Keunggulan Layanan Kami</h2>
        <p class="text-gray-300 max-w-3xl mx-auto">API yang kami sediakan dioptimalkan untuk performa terbaik dan kemudahan penggunaan</p>
      </div>
      
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
    <div class="feature-card animate-fadeIn">
      <div class="feature-icon">
        <i class="fas fa-bolt"></i>
      </div>
      <h3 class="text-xl font-bold mb-2 text-purple-300">Kecepatan Tinggi</h3>
      <p class="text-gray-300">Response time cepat dengan server yang dioptimalkan untuk aplikasi Anda.</p>
    </div>

    <div class="feature-card animate-fadeIn delay-100">
      <div class="feature-icon">
        <i class="fas fa-shield-alt"></i>
      </div>
      <h3 class="text-xl font-bold mb-2 text-purple-300">Keamanan Terjamin</h3>
      <p class="text-gray-300">Enkripsi end-to-end dan perlindungan data untuk menjaga informasi Anda tetap aman.</p>
    </div>

    <div class="feature-card animate-fadeIn delay-200">
      <div class="feature-icon">
        <i class="fas fa-code"></i>
      </div>
      <h3 class="text-xl font-bold mb-2 text-purple-300">Mudah Diintegrasikan</h3>
      <p class="text-gray-300">Dokumentasi lengkap dan SDK tersedia untuk beragam bahasa pemrograman.</p>
    </div>

    <div class="feature-card animate-fadeIn delay-300">
      <div class="feature-icon">
        <i class="fas fa-headset"></i>
      </div>
      <h3 class="text-xl font-bold mb-2 text-purple-300">Dukungan 24/7</h3>
      <p class="text-gray-300">Tim support kami siap membantu Anda kapanpun diperlukan.</p>
    </div>

    <div class="feature-card animate-fadeIn delay-400">
      <div class="feature-icon">
        <i class="fas fa-chart-line"></i>
      </div>
      <h3 class="text-xl font-bold mb-2 text-purple-300">Analytics Realtime</h3>
      <p class="text-gray-300">Pantau penggunaan API dan performa aplikasi Anda secara realtime.</p>
    </div>

    <div class="feature-card animate-fadeIn delay-500">
      <div class="feature-icon">
        <i class="fas fa-sync"></i>
      </div>
      <h3 class="text-xl font-bold mb-2 text-purple-300">Update Berkala</h3>
      <p class="text-gray-300">Layanan kami selalu diperbarui dengan fitur terbaru dan optimasi.</p>
    </div>
  </div>
</section>

    <!-- Search API Section -->
    <div class="glass mb-10 fade-up search-container">
      <i class="fas fa-search search-icon"></i>
      <input
        type="text"
        id="search_api"
        class="search-input"
        onkeyup="searchAPI()"
        placeholder="Cari API yang Anda butuhkan..."
        autocomplete="off"
        aria-label="Cari API"
      />
      <div class="mt-3 text-center text-sm text-gray-400">
        <span id="searchResults">Menampilkan semua API</span>
      </div>
    </div>

    <!-- API Sections -->
    <section class="space-y-14">
      <?php foreach ($apis as $category => $api_list): 
        $count = count($api_list);
      ?>
      <article class="glass fade-up" role="region" aria-labelledby="category-<?= strtolower($category) ?>">
        <div class="flex items-center mb-6 pb-3 border-b border-purple-600">
          <h2 id="category-<?= strtolower($category) ?>" class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-500 drop-shadow-md"><?= htmlspecialchars($category) ?></h2>
          <span class="api-count ml-3"><?= $count ?></span>
        </div>
        
        <div class="overflow-x-auto rounded-xl shadow-lg">
          <table class="w-full text-left text-white api-table">
            <thead>
              <tr>
                <th class="whitespace-nowrap">Nama API</th>
                <th class="whitespace-nowrap">Deskripsi</th>
                <th class="whitespace-nowrap text-center">Penggunaan</th>
                <th class="whitespace-nowrap text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($api_list as $api): ?>
              <tr tabindex="0" class="api-row" data-api-name="<?= strtolower(htmlspecialchars($api['name'])) ?>" data-api-desc="<?= strtolower(htmlspecialchars($api['desc'])) ?>" aria-label="API <?= htmlspecialchars($api['name']) ?>">
                <td class="font-semibold tracking-wide">
                  <div class="flex items-center">
                    <?php 
                    $iconClass = '';
                    switch(strtolower($api['name'])) {
                      case 'facebook': $iconClass = 'fab fa-facebook text-blue-500'; break;
                      case 'instagram': $iconClass = 'fab fa-instagram text-pink-500'; break;
                      case 'spotify': $iconClass = 'fab fa-spotify text-green-400'; break;
                      case 'tiktok': $iconClass = 'fab fa-tiktok text-gray-200'; break;
                      case 'ytmp3':
                      case 'ytmp4': $iconClass = 'fab fa-youtube text-red-500'; break;
                      case 'gpt4o': $iconClass = 'fas fa-robot text-purple-400'; break;
                      default: $iconClass = 'fas fa-code text-blue-400';
                    }
                    ?>
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-800 mr-3">
                      <i class="<?= $iconClass ?>"></i>
                    </span>
                    <?= htmlspecialchars($api['name']) ?>
                  </div>
                </td>
                <td class="text-gray-300"><?= htmlspecialchars($api['desc']) ?></td>
                <td class="text-center">
                  <span class="usage-counter"><?= number_format($api['usage']) ?></span>
                </td>
                <td class="text-center">
                  <div class="tooltip">
                    <button
                      onclick="openAPI('<?= htmlspecialchars($api['slug']) ?>')"
                      class="btn-primary"
                      aria-label="Try API <?= htmlspecialchars($api['name']) ?>"
                    >
                      <i class="fas fa-rocket"></i> Try
                    </button>
                    <span class="tooltip-text">Buka API <?= htmlspecialchars($api['name']) ?></span>
                  </div>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </article>
      <?php endforeach; ?>
    </section>

    <!-- WhatsApp Channel Section -->
    <section class="mt-24 fade-up text-center">
      <div class="glass rounded-3xl shadow-2xl ring-2 ring-green-400 ring-opacity-40 py-12 px-8">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-500 bg-opacity-20 mb-6">
          <i class="fab fa-whatsapp text-3xl text-green-400"></i>
        </div>
        <h2 class="text-4xl font-extrabold mb-5 text-green-400 select-none tracking-wide drop-shadow-md">Gabung Saluran WhatsApp</h2>
        <p class="mb-8 text-gray-300 text-lg font-medium max-w-2xl mx-auto">Dapatkan update terbaru, tips penggunaan API, dan informasi penting lainnya langsung dari saluran resmi kami.</p>
        <a href="https://whatsapp.com/channel/0029VaRI1OB2P59cTdJKZh3q" target="_blank" rel="noopener" class="btn-success">
          <i class="fab fa-whatsapp text-3xl"></i> Gabung Sekarang
          <i class="fas fa-arrow-right"></i>
        </a>
        <p class="mt-6 text-sm text-gray-400">Sudah ada <?= number_format(rand(3000, 8000)) ?> developer yang bergabung</p>
      </div>
    </section>

    <!-- FAQ Section -->
    <section class="mt-24 fade-up" id="faq">
      <div class="text-center mb-12">
        <h2 class="text-4xl font-extrabold mb-4 glow-text">Pertanyaan Umum</h2>
        <p class="text-gray-300 max-w-3xl mx-auto">Jawaban untuk pertanyaan yang sering ditanyakan</p>
      </div>
      
      <div class="glass">
        <div class="space-y-6" id="accordion">
          <?php 
          $faqs = [
            ["question" => "Bagaimana cara menggunakan API ini?", 
             "answer" => "Untuk menggunakan API, Anda cukup mengirimkan request ke endpoint yang tersedia dengan parameter yang dibutuhkan. Dokumentasi lengkap tersedia untuk setiap API."],
            ["question" => "Apakah API ini gratis?", 
             "answer" => "Kami menyediakan paket gratis dengan batasan penggunaan tertentu. Untuk penggunaan yang lebih intensif, tersedia paket premium dengan fitur tambahan."],
            ["question" => "Berapa rate limit untuk penggunaan API?", 
             "answer" => "Rate limit bervariasi tergantung jenis API dan paket langganan Anda. Secara umum, paket gratis memiliki limit 100 request per hari."],
            ["question" => "Bagaimana cara mendapatkan API key?", 
             "answer" => "Anda dapat mendaftar di website kami dan API key akan digenerate secara otomatis. API key diperlukan untuk setiap request yang Anda kirim."],
            ["question" => "Apakah API ini mendukung CORS?", 
             "answer" => "Ya, semua API kami mendukung CORS sehingga dapat diakses dari aplikasi frontend Anda secara langsung."]
          ];
          
          foreach($faqs as $index => $faq):
          ?>
          <div class="faq-item">
            <button class="w-full text-left px-6 py-4 rounded-xl bg-gray-800 bg-opacity-50 border border-purple-700 border-opacity-30 flex justify-between items-center font-semibold hover:bg-opacity-70 transition-all" onclick="toggleFaq(<?= $index ?>)">
              <?= htmlspecialchars($faq['question']) ?>
              <i class="fas fa-chevron-down text-purple-400 transition-transform duration-300" id="faq-icon-<?= $index ?>"></i>
            </button>
            <div class="faq-answer overflow-hidden max-h-0 transition-all duration-300" id="faq-answer-<?= $index ?>">
              <div class="p-6 text-gray-300">
                <?= htmlspecialchars($faq['answer']) ?>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- Contact Section -->
    <section class="mt-24 fade-up" id="contact">
      <div class="glass">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <div>
            <h2 class="text-3xl font-extrabold mb-6 text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-500">Hubungi Kami</h2>
            <p class="text-gray-300 mb-8">Ada pertanyaan atau membutuhkan bantuan? Jangan ragu untuk menghubungi tim kami.</p>
            
            <div class="space-y-4">
              <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-purple-700 bg-opacity-30 flex items-center justify-center flex-shrink-0">
                  <i class="fas fa-envelope text-purple-400"></i>
                </div>
                <div>
                  <p class="text-gray-400 text-sm">Email</p>
                  <p class="font-medium text-white">babykidss098@gmail.com</p>
                </div>
              </div>
              
              <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-green-700 bg-opacity-30 flex items-center justify-center flex-shrink-0">
                  <i class="fab fa-whatsapp text-green-400"></i>
                </div>
                <div>
                  <p class="text-gray-400 text-sm">WhatsApp</p>
                  <p class="font-medium text-white">+62 853-5897-7442</p>
                </div>
              </div>
              
              <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-blue-700 bg-opacity-30 flex items-center justify-center flex-shrink-0">
                  <i class="fab fa-telegram text-blue-400"></i>
                </div>
                <div>
                  <p class="text-gray-400 text-sm">Telegram</p>
                  <p class="font-medium text-white">@owensdev</p>
                </div>
              </div>
            </div>
          </div>
          
          <div class="bg-gray-800 bg-opacity-50 p-6 rounded-xl border border-purple-700 border-opacity-30">
            <h3 class="text-xl font-bold mb-4">Kirim Pesan</h3>
            <form id="contactForm">
              <div class="space-y-4">
                <div>
                  <label for="name" class="block text-sm font-medium text-gray-400 mb-1">Nama</label>
                  <input type="text" id="name" name="name" class="w-full bg-gray-700 bg-opacity-50 border border-gray-600 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
                
                <div>
                  <label for="email" class="block text-sm font-medium text-gray-400 mb-1">Email</label>
                  <input type="email" id="email" name="email" class="w-full bg-gray-700 bg-opacity-50 border border-gray-600 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
                
                <div>
                  <label for="message" class="block text-sm font-medium text-gray-400 mb-1">Pesan</label>
                  <textarea id="message" name="message" rows="4" class="w-full bg-gray-700 bg-opacity-50 border border-gray-600 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent"></textarea>
                </div>
                
                <button type="submit" class="btn-primary w-full justify-center">
                  <i class="fas fa-paper-plane"></i> Kirim Pesan
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>

    <footer class="mt-24 text-center text-gray-400 fade-up select-none" role="contentinfo" aria-label="Footer">
      <div class="flex justify-center space-x-6 mb-8">
        <a href="#" class="text-gray-400 hover:text-white transition-colors">
          <i class="fab fa-github text-2xl"></i>
        </a>
        <a href="#" class="text-gray-400 hover:text-white transition-colors">
          <i class="fab fa-twitter text-2xl"></i>
        </a>
        <a href="#" class="text-gray-400 hover:text-white transition-colors">
          <i class="fab fa-instagram text-2xl"></i>
        </a>
        <a href="#" class="text-gray-400 hover:text-white transition-colors">
          <i class="fab fa-linkedin text-2xl"></i>
        </a>
      </div>
      
      <div class="mb-8">
        <div class="flex flex-wrap justify-center gap-x-8 gap-y-4 text-sm">
          <a href="#" class="hover-underline text-gray-300 hover:text-white transition-colors">Kebijakan Privasi</a>
          <a href="#" class="hover-underline text-gray-300 hover:text-white transition-colors">Syarat & Ketentuan</a>
          <a href="#" class="hover-underline text-gray-300 hover:text-white transition-colors">Dokumentasi</a>
          <a href="#" class="hover-underline text-gray-300 hover:text-white transition-colors">Status</a>
          <a href="#" class="hover-underline text-gray-300 hover:text-white transition-colors">Blog</a>
        </div>
      </div>
      
      <p class="text-gray-500 text-sm">&copy; <?= date("Y") ?> OwensDev. All rights reserved.</p>
    </footer>
  </div>

  <button id="backToTop" class="back-to-top" aria-label="Back to top" title="Back to top" role="button" tabindex="0">
    <i class="fas fa-chevron-up"></i>
  </button>

  <script>
    // Animasi statistik dengan counter
    function animateCounter(id, target, duration = 2000) {
      const obj = document.getElementById(id);
      const start = 0;
      const range = target - start;
      const increment = target > 1000 ? 123 : 1;
      const stepTime = Math.abs(Math.floor(duration / (range / increment)));
      
      let current = start;
      const timer = setInterval(() => {
        current += increment;
        if (current > target) {
          obj.innerText = target.toLocaleString();
          clearInterval(timer);
        } else {
          obj.innerText = current.toLocaleString();
        }
      }, stepTime);
    }
    
    // Fungsi untuk membuka API
    function openAPI(slug) {
      const url = "<?= $api_base ?>/" + slug;
      window.open(url, "_blank", "noopener,noreferrer");
      
      // Tampilkan toast notification
      const toast = document.getElementById('toast');
      toast.style.display = 'flex';
      
      // Hilangkan toast setelah 3.5 detik
      setTimeout(() => {
        toast.style.display = 'none';
      }, 3500);
    }
    
    // Fungsi pencarian API
    function searchAPI() {
      const input = document.getElementById("search_api").value.toLowerCase();
      const rows = document.querySelectorAll(".api-row");
      let visibleCount = 0;
      
      rows.forEach(row => {
        const name = row.getAttribute("data-api-name");
        const desc = row.getAttribute("data-api-desc");
        
        if (name.includes(input) || desc.includes(input)) {
          row.style.display = "";
          visibleCount++;
        } else {
          row.style.display = "none";
        }
      });
      
      // Update hasil pencarian
      const searchResults = document.getElementById('searchResults');
      if (input === "") {
        searchResults.textContent = "Menampilkan semua API";
      } else if (visibleCount === 0) {
        searchResults.textContent = "Tidak ada hasil yang ditemukan";
      } else {
        searchResults.textContent = `Ditemukan ${visibleCount} API`;
      }
    }
    
    // Toggle FAQ
    function toggleFaq(index) {
      const answer = document.getElementById(`faq-answer-${index}`);
      const icon = document.getElementById(`faq-icon-${index}`);
      
      if (answer.style.maxHeight) {
        answer.style.maxHeight = null;
        icon.style.transform = "rotate(0deg)";
      } else {
        answer.style.maxHeight = answer.scrollHeight + "px";
        icon.style.transform = "rotate(180deg)";
      }
    }
    
    // Handle form submit
    document.getElementById('contactForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      // Simulasikan pengiriman form
      const submitBtn = this.querySelector('button[type="submit"]');
      const originalText = submitBtn.innerHTML;
      
      submitBtn.disabled = true;
      submitBtn.innerHTML = '<span class="loader"></span>';
      
      setTimeout(() => {
        submitBtn.innerHTML = '<i class="fas fa-check"></i> Pesan Terkirim';
        
        // Reset form
        this.reset();
        
        // Kembalikan tombol ke keadaan semula setelah beberapa saat
        setTimeout(() => {
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalText;
        }, 3000);
      }, 1500);
    });
    
    // Scroll event handlers
    window.addEventListener("scroll", () => {
      // Fade up animation on scroll
      document.querySelectorAll(".fade-up").forEach(el => {
        const rect = el.getBoundingClientRect();
        const delay = el.getAttribute('data-delay') || 0;
        
        if (rect.top < window.innerHeight - 100) {
          setTimeout(() => {
            el.classList.add("show");
          }, delay);
        }
      });
      
      // Back to top button
      const topBtn = document.getElementById("backToTop");
      if (window.scrollY > 300) {
        topBtn.classList.add('visible');
      } else {
        topBtn.classList.remove('visible');
      }
    });
    
    // Back to top button click
    document.getElementById("backToTop").onclick = () => {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    };
    
    // Keyboard accessibility for table rows
    document.querySelectorAll(".api-row").forEach(row => {
      row.addEventListener("keydown", e => {
        if (e.key === "Enter" || e.key === " ") {
          e.preventDefault();
          const btn = row.querySelector("button");
          if (btn) btn.click();
        }
      });
    });
    
    // Inisialisasi
    document.addEventListener('DOMContentLoaded', function() {
      // Trigger fade animations for elements in viewport
      document.querySelectorAll(".fade-up").forEach(el => {
        const rect = el.getBoundingClientRect();
        const delay = el.getAttribute('data-delay') || 0;
        
        if (rect.top < window.innerHeight - 100) {
          setTimeout(() => {
            el.classList.add("show");
          }, delay);
        }
      });
      
      // Animasi counter
      setTimeout(() => {
        animateCounter('apiCounter', <?= $totalApis ?>);
        animateCounter('usageCounter', <?= $totalUsage ?>);
      }, 500);
    });
    
    // Inisialisasi GSAP jika tersedia
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
      gsap.registerPlugin(ScrollTrigger);
      
      gsap.from('.feature-card', {
        scrollTrigger: {
          trigger: '#features',
          start: 'top 80%'
        },
        y: 50,
        opacity: 0,
        duration: 0.8,
        stagger: 0.2
      });
      
      gsap.from('.api-table', {
        scrollTrigger: {
          trigger: '.api-table',
          start: 'top 80%'
        },
        opacity: 0,
        scale: 0.95,
        duration: 0.8
      });
    }
  </script>
</body>
</html>