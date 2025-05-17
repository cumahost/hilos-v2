<?php
// Validasi $TEXT dan $lang tetap aman jika file ini dipanggil langsung
if (!isset($TEXT)) $TEXT = [];
if (!isset($lang)) $lang = 'es';

// Map halaman saat ini ke nama & ikon
$current_page = basename($_SERVER['PHP_SELF']);

// Daftar nama halaman dan ikon berdasarkan halaman aktif
$page_info = [
  'form.php' => [
    'label' => $TEXT['nav_form'] ?? 'Formulario',
    'icon'  => 'fa-clipboard-list',
    'href'  => 'form.php?lang=' . $lang,
  ],
  'confirm.php' => [
    'label' => $TEXT['nav_confirm'] ?? 'Confirmar',
    'icon'  => 'fa-check-circle',
    'href'  => 'confirm.php?lang=' . $lang,
  ],
  'done.php' => [
    'label' => $TEXT['nav_done'] ?? 'Finalizado',
    'icon'  => 'fa-flag-checkered',
    'href'  => 'done.php?lang=' . $lang,
  ],
];

// Ambil label dan ikon sesuai halaman aktif
$label = $page_info[$current_page]['label'] ?? 'Hilos Rosace';
$icon  = $page_info[$current_page]['icon'] ?? 'fa-circle';
$href  = $page_info[$current_page]['href'] ?? 'index.php';
?>

<!-- Header -->
<header class="bg-[#4e342e] text-white py-4 px-6 shadow-md">
  <div class="max-w-7xl mx-auto flex justify-between items-center">
    
    <!-- Logo -->
    <div class="flex items-center gap-3">
      <img src="logo.png" alt="Logo" class="h-10 w-auto">
      <!--<span class="font-semibold text-lg">Hilos Rosace</span>-->
    </div>

    <!-- Info halaman -->
    <div class="flex items-center gap-2">
      <i class="fas <?= $icon ?>"></i>
      <a href="<?= htmlspecialchars($href) ?>" class="hover:underline">
        <?= htmlspecialchars($label) ?>
      </a>
    </div>
  </div>
</header>
