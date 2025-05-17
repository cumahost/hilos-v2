<?php
session_start();

// Simulasi data dummy
$_SESSION['order_id'] = 'hilos-9999';

$_SESSION['products'] = [
  'HILOS-001' => 2,
  'HILOS-005' => 3,
  'HILOS-042' => 0, // tidak akan dikirim karena qty = 0
];

$_SESSION['customer'] = [
  'nombre' => 'Juan',
  'apellido' => 'Pérez',
  'direccion' => 'Calle Mayor 123',
  'poblacion' => 'Valencia',
  'provincia' => 'Valencia',
  'codigo_postal' => '46001',
  'pais' => 'España',
  'email' => 'cliente@ejemplo.com',
  'telefono' => '612345678',
  'mensaje' => 'Este es un pedido de prueba.',
  'como_conocio' => 'Google',
];

$_SESSION['lang'] = 'es';
$_SESSION['metodo_pago'] = 'transferencia';
$_SESSION['subtotal'] = 3.25; // dummy
$_SESSION['shipping'] = 4.50;
$_SESSION['total'] = 7.75;

// Jalankan script kirim email admin
require_once __DIR__ . '/send_admin.php';

echo '<h3>✅ Simulación de envío de email a ADMIN completada.</h3>';
echo '<p>Revisa el archivo <code>log/email.log</code> dan email info@hilosrosace.es.</p>';
