<?php
session_start();

// Cek semua session yang diperlukan
if (
  empty($_SESSION['products']) ||
  empty($_SESSION['customer']) ||
  empty($_SESSION['order_id'])
) {
  header("Location: index.php");
  exit;
}

// Ambil data dari session
$order_id = $_SESSION['order_id'];
$products = $_SESSION['products'];
$customer = $_SESSION['customer'];
$lang = $_POST['lang'] ?? $_SESSION['lang'] ?? 'es';
$metodo_pago = $_POST['metodo_pago'] ?? '';

// Load config dan bahasa
require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . "/lang/$lang.php";

// Hitung subtotal & total
$price_per_unit = $CONFIG['price_per_unit'];
$selected = array_filter($products, fn($qty) => intval($qty) > 0);
$subtotal = 0;
foreach ($selected as $qty) $subtotal += $qty * $price_per_unit;

// Hitung ongkir
$pais = strtolower($customer['pais']);
if ($pais === 'españa') {
  $shipping_cost = $metodo_pago === 'cod' ? $CONFIG['shipping']['cod'] : $CONFIG['shipping']['spain'];
} elseif (in_array($pais, ['canarias', 'baleares', 'ceuta', 'melilla'])) {
  $shipping_cost = $CONFIG['shipping']['canarias'];
} elseif (in_array($pais, ['francia', 'italia', 'alemania', 'portugal', 'reino unido', 'países bajos'])) {
  $shipping_cost = $CONFIG['shipping']['intl_europe'];
} else {
  $shipping_cost = $CONFIG['shipping']['intl_other'];
}

$total = $subtotal + $shipping_cost;

// Simpan metode pembayaran
$_SESSION['metodo_pago'] = $metodo_pago;
$_SESSION['subtotal'] = $subtotal;
$_SESSION['shipping'] = $shipping_cost;
$_SESSION['total'] = $total;

// Tambahan penting agar bizum-submit.php bisa membaca data
$_SESSION['order'] = [
  'order_id' => $order_id,
  'total' => $total,
  'payment' => $metodo_pago
];

// Kirim email ke admin & customer
require_once __DIR__ . '/mail/send_admin.php';
require_once __DIR__ . '/mail/send_customer.php';

// Redirect sesuai metode pembayaran
switch ($metodo_pago) {
  case 'paypal':
    header("Location: https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business={$CONFIG['paypal']['email']}&item_name=Pedido%20$order_id&amount=" . number_format($total, 2, '.', '') . "&currency_code=EUR&return=https://compra.hilosrosace.es/done.php?status=ok&order=$order_id&lang=$lang&method=paypal&total=$total");
    break;

  case 'bizum':
    header("Location: bizum-submit.php");
    break;

  case 'transferencia':
  case 'cod':
  default:
    header("Location: done.php?status=ok&order=$order_id&lang=$lang&method=$metodo_pago&total=$total");
    break;
}
exit;
