<?php
// Pastikan $TEXT tersedia, jika tidak, muat ulang sesuai session
if (!isset($TEXT)) {
  session_start();
  $lang = $_SESSION['lang'] ?? 'es';
  require_once __DIR__ . "/../lang/$lang.php";
}

// Daftar negara (label diambil dari $TEXT[])
$countries = [
  'España' => '🇪🇸 ' . ($TEXT['country_spain'] ?? 'España'),
  'Francia' => '🇫🇷 ' . ($TEXT['country_france'] ?? 'Francia'),
  'Italia' => '🇮🇹 ' . ($TEXT['country_italy'] ?? 'Italia'),
  'Alemania' => '🇩🇪 ' . ($TEXT['country_germany'] ?? 'Alemania'),
  'Portugal' => '🇵🇹 ' . ($TEXT['country_portugal'] ?? 'Portugal'),
  'Reino Unido' => '🇬🇧 ' . ($TEXT['country_uk'] ?? 'Reino Unido'),
  'Países Bajos' => '🇳🇱 ' . ($TEXT['country_netherlands'] ?? 'Países Bajos'),
  'Indonesia' => '🇮🇩 ' . ($TEXT['country_indonesia'] ?? 'Indonesia'),
  'Otro' => '🌍 ' . ($TEXT['country_other'] ?? 'Otro'),
];
?>

<!-- Formulir Data Pelanggan -->
<div class="bg-green-100 border-2 border-green-300 rounded-lg p-6 mt-8">
  <h2 class="text-2xl font-bold text-center mb-6 text-green-900">
    <i class="fas fa-user"></i> <?= $TEXT['customer_data'] ?? 'Customer Information' ?>
  </h2>

  <div class="grid md:grid-cols-2 gap-6">

    <!-- Nama Depan -->
    <div class="flex items-center border-b border-green-300">
      <i class="fas fa-user px-2 text-green-800"></i>
      <input type="text" name="nombre" required placeholder="<?= $TEXT['first_name'] ?? 'First Name' ?>"
        class="w-full py-2 px-3 bg-transparent focus:outline-none">
    </div>

    <!-- Nama Belakang -->
    <div class="flex items-center border-b border-green-300">
      <i class="fas fa-user px-2 text-green-800"></i>
      <input type="text" name="apellido" required placeholder="<?= $TEXT['last_name'] ?? 'Last Name' ?>"
        class="w-full py-2 px-3 bg-transparent focus:outline-none">
    </div>

    <!-- Alamat -->
    <div class="flex items-center border-b border-green-300 col-span-2">
      <i class="fas fa-map-marker-alt px-2 text-green-800"></i>
      <input type="text" name="direccion" required placeholder="<?= $TEXT['address'] ?? 'Address' ?>"
        class="w-full py-2 px-3 bg-transparent focus:outline-none">
    </div>

    <!-- Kota -->
    <div class="flex items-center border-b border-green-300">
      <i class="fas fa-city px-2 text-green-800"></i>
      <input type="text" name="poblacion" required placeholder="<?= $TEXT['city'] ?? 'City' ?>"
        class="w-full py-2 px-3 bg-transparent focus:outline-none">
    </div>

    <!-- Provinsi -->
    <div class="flex items-center border-b border-green-300">
      <i class="fas fa-map px-2 text-green-800"></i>
      <input type="text" name="provincia" required placeholder="<?= $TEXT['province'] ?? 'Province' ?>"
        class="w-full py-2 px-3 bg-transparent focus:outline-none">
    </div>

    <!-- Kode Pos -->
    <div class="flex items-center border-b border-green-300">
      <i class="fas fa-envelope px-2 text-green-800"></i>
      <input type="text" name="codigo_postal" required placeholder="<?= $TEXT['postal_code'] ?? 'Postal Code' ?>"
        class="w-full py-2 px-3 bg-transparent focus:outline-none">
    </div>

    <!-- Negara -->
    <div class="flex items-center border-b border-green-300">
      <i class="fas fa-flag px-2 text-green-800"></i>
      <select name="pais" required class="w-full py-2 px-3 bg-transparent focus:outline-none">
        <option value="" disabled selected><?= $TEXT['select_country'] ?? 'Select country' ?></option>
        <?php foreach ($countries as $value => $label): ?>
          <option value="<?= $value ?>"><?= $label ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Email -->
    <div class="flex items-center border-b border-green-300">
      <i class="fas fa-envelope-open-text px-2 text-green-800"></i>
      <input type="email" name="email" required placeholder="<?= $TEXT['email'] ?? 'Email' ?>"
        class="w-full py-2 px-3 bg-transparent focus:outline-none">
    </div>

    <!-- Telepon -->
    <div class="flex items-center border-b border-green-300">
      <i class="fas fa-phone px-2 text-green-800"></i>
      <input type="tel" name="telefono" required placeholder="<?= $TEXT['phone'] ?? 'Phone' ?>"
        class="w-full py-2 px-3 bg-transparent focus:outline-none">
    </div>

    <!-- Pesan -->
    <div class="flex items-center border-b border-green-300 col-span-2">
      <i class="fas fa-comment px-2 text-green-800"></i>
      <input type="text" name="mensaje" placeholder="<?= $TEXT['message'] ?? 'Message' ?>"
        class="w-full py-2 px-3 bg-transparent focus:outline-none">
    </div>

    <!-- Sumber Info -->
    <div class="flex items-center border-b border-green-300 col-span-2">
      <i class="fas fa-question-circle px-2 text-green-800"></i>
      <select name="como_conocio" required class="w-full py-2 px-3 bg-transparent focus:outline-none">
        <option value="" disabled selected><?= $TEXT['how_did_you_find_us'] ?? 'How did you find us?' ?></option>
        <option value="Google">Google</option>
        <option value="Facebook">Facebook</option>
        <option value="Instagram">Instagram</option>
        <option value="Recommendation"><?= $TEXT['recommendation'] ?? 'Recommendation' ?></option>
        <option value="Others"><?= $TEXT['other'] ?? 'Other' ?></option>
      </select>
    </div>

  </div>
</div>
