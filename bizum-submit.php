<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__.'/inc/config.php';

if (!isset($_SESSION)) session_start();

$order = $_SESSION['order'] ?? null;

if (!$order || !isset($order['total']) || !isset($order['order_id'])) {
  file_put_contents(__DIR__.'/log/bizum.log', date('c') . " - Invalid session\n", FILE_APPEND);
  echo "Invalid session data.";
  exit;
}

$amount = number_format($order['total'], 2, '', '') * 100;

$params = [
  'Ds_Merchant_Amount' => (string)$amount,
  'Ds_Merchant_Order' => str_pad($order['order_id'], 12, '0', STR_PAD_LEFT),
  'Ds_Merchant_MerchantCode' => $bizum_merchant,
  'Ds_Merchant_Currency' => $bizum_currency,
  'Ds_Merchant_TransactionType' => '0',
  'Ds_Merchant_Terminal' => $bizum_terminal,
  'Ds_Merchant_MerchantURL' => 'https://compra.hilosrosace.es/bizum-response.php',
  'Ds_Merchant_UrlOK' => 'https://compra.hilosrosace.es/done.php',
  'Ds_Merchant_UrlKO' => 'https://compra.hilosrosace.es/done.php',
  'Ds_Merchant_ConsumerLanguage' => '001',
  'Ds_Merchant_ProductDescription' => 'Pedido de hilo',
  'Ds_Merchant_MerchantName' => 'Hilos Rosace',
];

$merchantParamsJson = json_encode($params, JSON_UNESCAPED_SLASHES);
$merchantParams = base64_encode($merchantParamsJson);
$signature = base64_encode(hash_hmac('sha256', $merchantParams, base64_decode($bizum_key), true));

file_put_contents(__DIR__.'/log/bizum.log', date('c') . " - Params: $merchantParamsJson\n", FILE_APPEND);

?><!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Redirigiendo a Bizum...</title>
</head>
<body onload="document.forms[0].submit()">
  <form action="<?= $bizum_gateway ?>" method="POST">
    <input type="hidden" name="Ds_SignatureVersion" value="HMAC_SHA256_V1">
    <input type="hidden" name="Ds_MerchantParameters" value="<?= $merchantParams ?>">
    <input type="hidden" name="Ds_Signature" value="<?= $signature ?>">
    <noscript>
      <p>Redirección automática desactivada. Haga clic en el botón para continuar.</p>
      <button type="submit">Pagar con Bizum</button>
    </noscript>
  </form>
</body>
</html>
