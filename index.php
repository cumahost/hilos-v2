<?php
// Aktifkan session jika belum
if (session_status() === PHP_SESSION_NONE) session_start();

// Atur default bahasa jika belum dipilih
$lang = $_GET['lang'] ?? null;
if ($lang && in_array($lang, ['es', 'en'])) {
    $_SESSION['lang'] = $lang;
    header("Location: form.php?lang=$lang");
    exit;
}

// Load teks multibahasa default (Spanyol)
require_once __DIR__ . '/lang/es.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $TEXT['welcome_title'] ?? 'Bienvenido a Hilos Rosace' ?></title>
  <link href="../assets/css/style.css" rel="stylesheet">
  <!-- Font Awesome CDN -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>
<body class="bg-cover bg-center min-h-screen flex items-center justify-center" style="background-image: url('bg-hilos.jpg');">
  <!-- Wrapper transparan -->
  <div class="bg-white/50 backdrop-blur-md p-10 rounded-xl shadow-xl max-w-xl w-full text-center">
 
    <!-- Logo -->
    <img src="logo.png" alt="Logo Hilos Rosace" class="mx-auto mb-6 w-40">

    <!-- Judul -->
    <h1 class="text-2xl font-bold mb-2"><?= $TEXT['welcome_heading'] ?? 'Bienvenido a Hilos Rosace' ?></h1>
    <p class="text-gray-700 mb-6"><?= $TEXT['welcome_subheading'] ?? 'Selecciona tu idioma para comenzar tu pedido' ?></p>

    <!-- Pilihan Bahasa -->
    <div class="flex justify-center space-x-6 mb-6">
      <!-- Tombol Español -->
      <a href="?lang=es" class="bg-neutral-700 hover:bg-rose-800 text-white font-semibold py-2 px-5 rounded-full flex items-center gap-2">
      <span>🇪🇸</span> <?= $TEXT['language_es'] ?? 'Español' ?>
      </a>
      <!-- Tombol English -->
      <a href="?lang=en" class="bg-blue-700 hover:bg-blue-800 text-white font-semibold py-2 px-5 rounded-full flex items-center gap-2">
        <span>🇬🇧</span> <?= $TEXT['language_en'] ?? 'English' ?>
      </a>
    </div>

    <!-- Footer -->
    <p class="text-xs text-gray-600">
      <?= $TEXT['maintained_by'] ?? 'Created & Maintained by' ?> 
      <a href="https://kutaweb.com" target="_blank" class="text-yellow-600 hover:underline">KutaWeb</a>
    </p>
  </div>

</body>
</html>
