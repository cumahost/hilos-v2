<?php

$CONFIG = [

  // Harga produk (per unit)
  'price_per_unit' => 0.65,

  // Ongkos kirim
  'shipping' => [
    'spain' => 6.50,
    'cod' => 9.50,
    'canarias' => 6.50,
    'intl_europe' => 12.90,
    'intl_other' => 12.90,
  ],

  // Informasi email SMTP (untuk pengiriman email)
  'email' => [
    'from' => 'info@hilosrosace.es',
    'smtp_host' => 'mail.hilosrosace.es',
    'smtp_port' => 465,
    'smtp_user' => 'test@hilosrosace.es',
    'smtp_pass' => '(AvriH16$[mb',
  ],

  // Informasi pembayaran PayPal
  'paypal' => [
    'email' => 'ebay@hilosrosace.es',
    'client_id' => 'ASPH7FuUbeoQYLR1sltcOe7Czi6CZ9rYPLKRekR39NdFs0j7wZU2XFEqQZNNL5nJ3cZyz2xbod3zc6aU',
  ],

  // Informasi pembayaran Bizum
  'bizum' => [
    'merchant_id' => '034804666',
    'terminal_id' => '1',
    'sha256_key' => 'sq7HjrUOBfKmC576ILgskD5srU870gJ7',
    'bizum_gateway' => 'https://sis.redsys.es/sis/realizarPago',
    'bizum_merchant' => 'hilosrosace',
  ],

  // Informasi rekening transfer manual (atas nama Maria Dolores Martin)
  'iban' => [
    'bankinter'  => 'ES6701280689260105088896',
    'santander'  => 'ES7500494362172310006882',
  ],

  // Branding
  'brand' => [
    'name' => 'Hilos Rosace',
    'logo' => 'logo.png',
    'bg_image' => 'bg-hilos.jpg',
    'maintained_by' => 'KutaWeb',
    'maintainer_url' => 'https://kutaweb.com',
  ],

];
