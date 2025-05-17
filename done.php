<?php
session_start();

// Ambil data dari URL (backup untuk tampilkan hasil)
$status = $_GET['status'] ?? 'ok';
$order_id = $_GET['order'] ?? ($_SESSION['order_id'] ?? '');
$lang = $_GET['lang'] ?? ($_SESSION['lang'] ?? 'es');
$method = $_GET['method'] ?? ($_SESSION['metodo_pago'] ?? '');
$total = $_GET['total'] ?? ($_SESSION['total'] ?? '');

// Load teks
require_once __DIR__ . "/lang/$lang.php";
require_once __DIR__ . "/inc/config.php";
?>

<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
  <meta charset="UTF-8">
  <title><?= $TEXT['done_title'] ?? 'Pedido Finalizado' ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../assets/css/style.css" rel="stylesheet">
  <!-- Tailwind & FontAwesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-cover bg-center min-h-screen" style="background-image: url('bg-hilos.jpg');">

<?php include __DIR__ . '/inc/header.php'; ?>

<div class="max-w-xl mx-auto bg-white/90 backdrop-blur-md p-8 mt-10 rounded-lg shadow-lg text-center">

  <?php if ($status === 'ok'): ?>
    <!-- Sukses -->
    <i class="fas fa-check-circle text-green-600 text-5xl mb-4"></i>
    <h1 class="text-2xl font-bold mb-2"><?= $TEXT['thank_you'] ?? '¡Gracias por tu pedido!' ?></h1>
    <p class="mb-4"><?= $TEXT['order_received'] ?? 'Hemos recibido tu pedido correctamente.' ?></p>
    <div class="text-sm text-gray-700 mb-6">
      <p><strong><?= $TEXT['order_number'] ?? 'Número de pedido' ?>:</strong> <?= $order_id ?></p>
      <?php
        $payment_labels = [
          'paypal'        => $TEXT['payment_paypal'] ?? 'PayPal',
          'bizum'         => $TEXT['payment_bizum'] ?? 'Bizum',
          'transferencia' => $TEXT['payment_transfer'] ?? 'Bank Transfer',
          'cod'           => $TEXT['payment_cod'] ?? 'Cash on Delivery'
        ];
        $method_label = $payment_labels[strtolower($method)] ?? ucfirst($method);
        ?>
      <p><strong><?= $TEXT['payment_method'] ?? 'Payment Method' ?>:</strong> <?= $method_label ?></p>
      <p><strong><?= $TEXT['total'] ?? 'Total' ?>:</strong> €<?= number_format((float)$total, 2) ?></p>
    </div>
  <?php else: ?>
    <!-- Gagal -->
    <i class="fas fa-times-circle text-red-600 text-5xl mb-4"></i>
    <h1 class="text-2xl font-bold mb-2"><?= $TEXT['error_title'] ?? 'Hubo un error' ?></h1>
    <p class="mb-6 text-red-700"><?= $TEXT['error_message'] ?? 'Tu pedido no pudo ser procesado.' ?></p>
  <?php endif; ?>

  <!-- Tombol WhatsApp & Home -->
  <div class="flex flex-col sm:flex-row gap-4 justify-center">
  <?php
  // Pesan WhatsApp multilingual
    $whatsapp_message = ($lang === 'en')
      ? "Hello, my order number is $order_id"
      : "Hola, número de pedido $order_id";
?>
<a href="https://wa.me/34965240207?text=<?= urlencode($whatsapp_message) ?>" target="_blank"
  class="w-full sm:w-1/2 bg-green-600 hover:bg-green-700 text-white py-3 rounded flex justify-center items-center gap-2">
  <i class="fab fa-whatsapp"></i> <?= $TEXT['contact_whatsapp'] ?? 'Contactar por WhatsApp' ?>
</a>


    <!-- Volver al inicio -->
    <a href="index.php?lang=<?= $lang ?>"
      class="w-full sm:w-1/2 bg-gray-700 hover:bg-gray-800 text-white py-3 rounded flex justify-center items-center gap-2">
      <i class="fas fa-house"></i> <?= $TEXT['back_home'] ?? 'Volver al Inicio' ?>
    </a>
  </div>

</div>

<?php include __DIR__ . '/inc/footer.php'; ?>

</body>
</html>
