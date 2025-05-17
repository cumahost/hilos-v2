<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Autoload PHPMailer
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../inc/config.php';

// Ambil semua data dari session
$order_id = $_SESSION['order_id'] ?? '';
$products = $_SESSION['products'] ?? [];
$customer = $_SESSION['customer'] ?? [];
$lang     = $_SESSION['lang'] ?? 'es';
$subtotal = $_SESSION['subtotal'] ?? 0;
$shipping = $_SESSION['shipping'] ?? 0;
$total    = $_SESSION['total'] ?? 0;
$method   = $_SESSION['metodo_pago'] ?? '';

// Load teks sesuai bahasa
require_once __DIR__ . "/../lang/$lang.php";

// Dapatkan body email HTML dari template
ob_start();
include __DIR__ . '/template_customer.php';
$body = ob_get_clean();

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

  $mail->setFrom($CONFIG['email']['from'], 'Hilos Rosace');
  $mail->addReplyTo($CONFIG['email']['from']);
  $mail->addAddress($customer['email'], $customer['nombre'] . ' ' . $customer['apellido']);

  $mail->isHTML(true);
  $mail->Subject = $TEXT['customer_email_subject'] . ' - ' . $order_id;
  $mail->Body    = $body;

  $mail->send();

  // Log sukses
  file_put_contents(__DIR__ . '/../log/email.log', "[OK][$order_id] Email cliente enviado\n", FILE_APPEND);
} catch (Exception $e) {
  file_put_contents(__DIR__ . '/../log/email.log', "[ERROR][$order_id] Email cliente falló: {$mail->ErrorInfo}\n", FILE_APPEND);
}
