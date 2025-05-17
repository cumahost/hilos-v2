<?php
session_start();

// Simulasi data dummy pelanggan
$_SESSION['order_id'] = 'hilos-8888';

$_SESSION['products'] = [
  'HILOS-1234' => 1,
  'HILOS-5678' => 2,
  'HILOS-9999' => 0, // tidak akan dikirim
];

$_SESSION['customer'] = [
  'nombre' => 'Ana',
  'apellido' => 'Martínez',
  'direccion' => 'Av. Libertad 45',
  'poblacion' => 'Sevilla',
  'provincia' => 'Sevilla',
  'codigo_postal' => '41001',
  'pais' => 'España',
  'email' => 'rahmat@syaiman.com', // <- ganti ini jika perlu test ke akunmu
  'telefono' => '612345678',
  'mensaje' => 'Pedido de prueba para cliente.',
  'como_conocio' => 'Instagram',
];

$_SESSION['lang'] = 'es';
$_SESSION['metodo_pago'] = 'paypal';
$_SESSION['subtotal'] = 1.95;
$_SESSION['shipping'] = 4.50;
$_SESSION['total'] = 6.45;

// Jalankan script kirim email ke pelanggan
require_once __DIR__ . '/send_customer.php';

echo '<h3>✅ Simulación de envío de email a CLIENTE completada.</h3>';
echo '<p>Revisa <code>log/email.log</code> dan inbox pelanggan.</p>';
