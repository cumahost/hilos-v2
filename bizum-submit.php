<?php
session_start();
require_once __DIR__ . '/config.php';

// Ambil data dari session
$order_id = $_SESSION['order_id'] ?? 'hilos-0000';
$total = $_SESSION['total'] ?? 0;
$lang = $_SESSION['lang'] ?? 'es';

// Konversi total ke format sen (contoh: €12.34 => 1234)
$amount = number_format(floatval($total) * 100, 0, '', '');

// Ambil data Bizum dari config
$merchant_code = $CONFIG['bizum']['merchant_id'];
$terminal = $CONFIG['bizum']['terminal_id'];
$secret_key = $CONFIG['bizum']['sha256_key'];

// Data dasar untuk Redsys
$currency = '978'; // Euro
$transaction_type = '0'; // default
$url_notification = 'https://compra.hilosrosace.es/bizum-response.php';
$url_ok = 'https://compra.hilosrosace.es/done.php?status=ok&order=' . $order_id . '&lang=' . $lang . '&method=bizum&total=' . $total;
$url_ko = 'https://compra.hilosrosace.es/done.php?status=fail&order=' . $order_id . '&lang=' . $lang . '&method=bizum';

// Array merchant params
$merchant_params = [
  "DS_MERCHANT_AMOUNT" => $amount,
  "DS_MERCHANT_ORDER" => str_pad(preg_replace('/[^0-9]/', '', $order_id), 12, "0", STR_PAD_LEFT),
  "DS_MERCHANT_MERCHANTCODE" => $merchant_code,
  "DS_MERCHANT_CURRENCY" => $currency,
  "DS_MERCHANT_TRANSACTIONTYPE" => $transaction_type,
  "DS_MERCHANT_TERMINAL" => $terminal,
  "DS_MERCHANT_MERCHANTURL" => $url_notification,
  "DS_MERCHANT_URLOK" => $url_ok,
  "DS_MERCHANT_URLKO" => $url_ko,
  "DS_MERCHANT_TITULAR" => "Hilos Rosace",
  "DS_MERCHANT_PRODUCTDESCRIPTION" => "Pedido $order_id",
  "DS_MERCHANT_PAYMETHODS" => "z" // z = Bizum
];

// Encode base64 JSON
$json_params = json_encode(["Ds_MerchantParameters" => $merchant_params]);
$encoded_params = base64_encode($json_params);

// Buat signature
$signature = base64_encode(hash_hmac('sha256', $encoded_params, base64_decode($secret_key), true));

// Endpoint Redsys produksi:
$endpoint = 'https://sis.redsys.es/sis/realizarPago';
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
  <meta charset="UTF-8">
  <title>Conectando con Bizum...</title>
</head>
<body onload="document.forms['bizumForm'].submit();">
  <p><?= $lang === 'en' ? 'Connecting to Bizum...' : 'Conectando con Bizum...' ?></p>
  <form name="bizumForm" method="post" action="<?= $endpoint ?>">
    <input type="hidden" name="Ds_SignatureVersion" value="HMAC_SHA256_V1" />
    <input type="hidden" name="Ds_MerchantParameters" value="<?= $encoded_params ?>" />
    <input type="hidden" name="Ds_Signature" value="<?= $signature ?>" />
  </form>
</body>
</html>
