<?php
// Aktifkan session
if (session_status() === PHP_SESSION_NONE) session_start();

// Ambil bahasa dari session atau query
$lang = $_GET['lang'] ?? $_SESSION['lang'] ?? 'es';
if (!in_array($lang, ['es', 'en'])) $lang = 'es';
$_SESSION['lang'] = $lang;

// Load file bahasa
require_once __DIR__ . "/lang/$lang.php";

// Cek apakah form sudah dikirim tanpa produk
$error = $_GET['error'] ?? null;
?>

<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $TEXT['form_title'] ?? 'Formulario de Pedido' ?></title>
  <link href="../assets/css/style.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>
<body class="bg-cover bg-center bg-no-repeat bg-fixed min-h-screen" style="background-image: url('bg-hilos.jpg');">

  <!-- Include: Header -->
  <?php include __DIR__ . '/inc/header.php'; ?>

  <!-- Kontainer utama -->
  <div class="max-w-7xl mx-auto px-4 py-8 bg-white/20 backdrop-blur rounded-lg shadow-xl mt-6">

    <!-- Judul halaman -->
    <h1 class="text-center text-3xl font-bold mb-8 text-gray-800">
      <?= $TEXT['form_heading'] ?? 'Formulario de Pedido' ?>
    </h1>

    <!-- Tampilkan error jika tidak ada produk dipilih -->
    <?php if ($error === 'missing_products'): ?>
      <div class="bg-red-100 text-red-700 p-4 rounded mb-6 text-center font-semibold">
        <?= $TEXT['error_no_products'] ?? 'Por favor, seleccione al menos un producto para continuar.' ?>
      </div>
    <?php endif; ?>

    <form action="confirm.php" method="POST">
      <!-- Include: Grid Produk -->
      <?php include __DIR__ . '/inc/product-grid.php'; ?>

      <!-- Include: Form Data Pelanggan -->
      <?php include __DIR__ . '/inc/customer-form.php'; ?>

      <!-- Tombol Aksi -->
      <div class="flex justify-between mt-8 gap-4">
        <!-- Tombol Reset -->
        <button type="reset" class="w-1/2 bg-gray-500 hover:bg-gray-600 text-white py-3 rounded flex justify-center items-center gap-2">
          <i class="fas fa-rotate-left"></i> <?= $TEXT['reset'] ?? 'Borrar' ?>
        </button>
        <!-- Tombol Submit -->
        <button type="submit" class="w-1/2 bg-blue-700 hover:bg-blue-800 text-white py-3 rounded flex justify-center items-center gap-2">
          <i class="fas fa-arrow-right"></i> <?= $TEXT['continue'] ?? 'Continuar' ?>
        </button>
      </div>
    </form>
  </div>

  <!-- Include: Footer -->
  <?php include __DIR__ . '/inc/footer.php'; ?>

</body>
</html>
