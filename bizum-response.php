<?php
// bizum-response.php — Redsys Notification Handler
require_once __DIR__ . '/config.php';

// Fungsi logging sederhana
function log_bizum($data) {
  $log_path = __DIR__ . '/log/bizum.log';
  $entry = "[" . date('Y-m-d H:i:s') . "] " . $data . PHP_EOL;
  file_put_contents($log_path, $entry, FILE_APPEND);
}

// Tangani POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  exit('Method Not Allowed');
}

$signature_version = $_POST['Ds_SignatureVersion'] ?? '';
$encoded_params = $_POST['Ds_MerchantParameters'] ?? '';
$received_signature = $_POST['Ds_Signature'] ?? '';

if (!$encoded_params || !$received_signature) {
  log_bizum("Missing parameters");
  exit('ERROR');
}

// Decode parameter
$decoded_json = base64_decode($encoded_params);
$params = json_decode($decoded_json, true);

// Validasi signature
$secret_key = base64_decode($CONFIG['bizum']['sha256_key']);
$expected_signature = base64_encode(hash_hmac('sha256', $encoded_params, $secret_key, true));

// Cek signature
if ($expected_signature !== $received_signature) {
  log_bizum("Invalid signature");
  exit('ERROR');
}

// Ambil data transaksi
$order_id = $params['Ds_Order'] ?? 'UNKNOWN';
$response_code = intval($params['Ds_Response'] ?? 999);
$result = ($response_code < 100) ? 'SUCCESS' : 'FAIL';

log_bizum("Order: $order_id | Response: $response_code | Result: $result");

// Kirim respon ke Redsys
echo 'OK';
