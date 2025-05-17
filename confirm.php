<?php
session_start();

// Ambil data dari form sebelumnya
$products = $_POST['qty'] ?? [];
$customer = [
  'nombre' => $_POST['nombre'] ?? '',
  'apellido' => $_POST['apellido'] ?? '',
  'direccion' => $_POST['direccion'] ?? '',
  'poblacion' => $_POST['poblacion'] ?? '',
  'provincia' => $_POST['provincia'] ?? '',
  'codigo_postal' => $_POST['codigo_postal'] ?? '',
  'pais' => $_POST['pais'] ?? '',
  'email' => $_POST['email'] ?? '',
  'telefono' => $_POST['telefono'] ?? '',
  'mensaje' => $_POST['mensaje'] ?? '',
  'como_conocio' => $_POST['como_conocio'] ?? '',
];

// Simpan ke session
$_SESSION['products'] = $products;
$_SESSION['customer'] = $customer;

// Validasi minimal 1 produk
$selected = array_filter($products, fn($qty) => intval($qty) > 0);
if (count($selected) === 0) {
  $lang = $_SESSION['lang'] ?? 'es';
  header("Location: form.php?lang=$lang&error=missing_products");
  exit;
}


// Ambil bahasa
$lang = $_GET['lang'] ?? $_SESSION['lang'] ?? 'es';
if (!in_array($lang, ['es', 'en'])) $lang = 'es';
$_SESSION['lang'] = $lang;

// Load config dan bahasa
require_once __DIR__ . "/inc/config.php";
require_once __DIR__ . "/lang/$lang.php";

// Buat order ID
$order_id = 'hilos-' . rand(1000, 9999);
$_SESSION['order_id'] = $order_id;

// Hitung subtotal
$price_per_unit = $CONFIG['price_per_unit'];
$subtotal = 0;
foreach ($selected as $qty) {
  $subtotal += $qty * $price_per_unit;
}

// Hitung ongkir
$pais = strtolower($customer['pais']);
if ($pais === 'españa') {
  $shipping_cost = $CONFIG['shipping']['spain'];
} elseif ($pais === 'canarias' || $pais === 'baleares' || $pais === 'ceuta' || $pais === 'melilla') {
  $shipping_cost = $CONFIG['shipping']['canarias'];
} elseif (in_array($pais, ['francia', 'italia', 'alemania', 'portugal', 'reino unido', 'países bajos'])) {
  $shipping_cost = $CONFIG['shipping']['intl_europe'];
} else {
  $shipping_cost = $CONFIG['shipping']['intl_other'];
}

// Total
$total = $subtotal + $shipping_cost;
?>

<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
  <meta charset="UTF-8">
  <title><?= $TEXT['confirm_title'] ?? 'Confirmar Pedido' ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../assets/css/style.css" rel="stylesheet">
  <!-- Tailwind & FontAwesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-cover bg-center min-h-screen" style="background-image: url('bg-hilos.jpg');">

<?php include __DIR__ . '/inc/header.php'; ?>

<div class="max-w-4xl mx-auto bg-white/90 p-6 mt-10 rounded shadow-lg backdrop-blur">
  <h1 class="text-2xl font-bold text-center mb-6"><?= $TEXT['confirm_heading'] ?? 'Resumen del Pedido' ?></h1>

  <!-- Tabel produk -->
  <div class="overflow-x-auto">
    <table class="w-full text-sm text-left mb-8">
      <thead>
        <tr class="bg-rose-800 text-white">
          <th class="p-2">#</th>
          <th class="p-2"><?= $TEXT['product'] ?? 'Producto' ?></th>
          <th class="p-2"><?= $TEXT['qty'] ?? 'Cantidad' ?></th>
          <th class="p-2"><?= $TEXT['price'] ?? 'Precio' ?></th>
          <th class="p-2"><?= $TEXT['subtotal'] ?? 'Subtotal' ?></th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; foreach ($selected as $code => $qty): ?>
        <tr class="border-b">
          <td class="p-2"><?= $no++ ?></td>
          <td class="p-2 font-semibold"><?= htmlspecialchars($code) ?></td>
          <td class="p-2"><?= intval($qty) ?></td>
          <td class="p-2">€<?= number_format($price_per_unit, 2) ?></td>
          <td class="p-2">€<?= number_format($qty * $price_per_unit, 2) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- Informasi Pelanggan -->
  <div class="grid md:grid-cols-2 gap-4 text-sm bg-green-100 border-2 border-green-300 p-4 rounded mb-6">
    <?php foreach ($customer as $key => $value): ?>
      <?php if ($value): ?>
        <div><strong><?= ucfirst(str_replace('_', ' ', $key)) ?>:</strong> <?= htmlspecialchars($value) ?></div>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>

  <!-- Ringkasan -->
  <div class="text-right text-sm mb-4">
    <p><strong><?= $TEXT['subtotal'] ?? 'Subtotal' ?>:</strong> €<?= number_format($subtotal, 2) ?></p>
    <?php
  $country_label = $customer['pais'];
  if (in_array(strtolower($country_label), ['otro', 'other'])) {
    $country_label = 'International';
  }
?>
<p><strong><?= $TEXT['shipping'] ?? 'Envío' ?> (<?= $country_label ?>):</strong> €<?= number_format($shipping_cost, 2) ?></p>

    <p class="text-lg mt-2 font-bold text-rose-700"><strong><?= $TEXT['total'] ?? 'Total' ?>:</strong> €<?= number_format($total, 2) ?></p>
  </div>

  <!-- Metode Pembayaran -->
  <form action="finalize.php" method="POST">
    <input type="hidden" name="lang" value="<?= $lang ?>">

    <div class="mb-6">
      <label for="metodo" class="block mb-1 font-semibold">
        <?= $TEXT['payment_method'] ?? 'Método de pago' ?>
      </label>
      <select name="metodo_pago" id="metodo" required class="w-full border border-gray-300 rounded px-4 py-2">
        <option value="" disabled selected><?= $TEXT['select_payment'] ?? 'Seleccione una opción' ?></option>
        <option value="transferencia"><?= $TEXT['payment_transfer'] ?? 'Transferencia Bancaria' ?></option>
        <?php if (strtolower($customer['pais']) === 'españa'): ?>
          <option value="bizum">Bizum</option>
          <option value="cod">Contra Reembolso</option>
        <?php endif; ?>
        <option value="paypal">PayPal</option>
      </select>
    </div>

    <!-- Tombol aksi -->
    <div class="flex gap-4">
      <a href="form.php?lang=<?= $lang ?>" class="w-1/2 bg-gray-500 hover:bg-gray-600 text-white py-3 rounded flex justify-center items-center gap-2">
        <i class="fas fa-pen-to-square"></i> <?= $TEXT['edit_order'] ?? 'Editar Pedido' ?>
      </a>
      <button type="submit" class="w-1/2 bg-blue-700 hover:bg-blue-800 text-white py-3 rounded flex justify-center items-center gap-2">
        <i class="fas fa-paper-plane"></i> <?= $TEXT['confirm_order'] ?? 'Confirmar Pedido' ?>
      </button>
    </div>
  </form>
</div>

<?php include __DIR__ . '/inc/footer.php'; ?>

</body>
</html>
