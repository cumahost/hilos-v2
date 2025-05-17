<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Autoload PHPMailer
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../inc/config.php';

// Data penting dari session
$order_id = $_SESSION['order_id'] ?? '';
$products = $_SESSION['products'] ?? [];
$customer = $_SESSION['customer'] ?? [];
$lang     = $_SESSION['lang'] ?? 'es';
$subtotal = $_SESSION['subtotal'] ?? 0;
$shipping = $_SESSION['shipping'] ?? 0;
$total    = $_SESSION['total'] ?? 0;
$method   = $_SESSION['metodo_pago'] ?? '';
$ip       = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
$ref      = $_SERVER['HTTP_REFERER'] ?? 'direct';

// Ambil isi email admin (plaintext) dari template
require_once __DIR__ . '/template_admin.php';
$body = generateAdminEmailBody(
  $order_id,
  $customer,
  $products,
  $subtotal,
  $shipping,
  $total,
  $method,
  $ip,
  $ref
);

// Kirim email
$mail = new PHPMailer(true);
try {
  $mail->isSMTP();
  $mail->Host = $CONFIG['email']['smtp_host'];
  $mail->SMTPAuth = true;
  $mail->Username = $CONFIG['email']['smtp_user'];
  $mail->Password = $CONFIG['email']['smtp_pass'];
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
  $mail->Port = $CONFIG['email']['smtp_port'];
  $mail->CharSet = 'UTF-8'; // ✅ FIX karakter aneh

  $mail->setFrom($CONFIG['email']['from'], 'Hilos Rosace');
  $mail->addReplyTo($CONFIG['email']['from']);
  $mail->addAddress($CONFIG['email']['from']);

  $mail->isHTML(false); // plaintext
  $mail->Subject = "Nuevo pedido - $order_id";
  $mail->Body    = $body;

  $mail->send();

  // Log sukses
  file_put_contents(__DIR__ . '/../log/email.log', "[OK][$order_id] Email admin enviado\n", FILE_APPEND);
} catch (Exception $e) {
  file_put_contents(__DIR__ . '/../log/email.log', "[ERROR][$order_id] Email admin falló: {$mail->ErrorInfo}\n", FILE_APPEND);
}
