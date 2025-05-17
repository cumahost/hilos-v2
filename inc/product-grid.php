<?php
// Pastikan $TEXT dan $CONFIG sudah tersedia
if (!isset($TEXT)) $TEXT = [];
require_once __DIR__ . '/config.php';

// Folder gambar
$img_dir = __DIR__ . '/../img/';

// Ambil semua file gambar dari folder img (hanya *.jpg)
$images = glob($img_dir . '*.jpg');

// Urutkan secara natural
natsort($images);

// Konversi path ke nama file saja
$images = array_map('basename', $images);

// Tampilkan dalam bentuk grid
echo '<div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-4 mb-10">';

// Loop semua gambar
foreach ($images as $img_file):
  // Ambil kode produk dari nama file, misal hilos-123.jpg → HILOS-123
  $code = strtoupper(pathinfo($img_file, PATHINFO_FILENAME));
  $price = number_format($CONFIG['price_per_unit'], 2);
?>
  <div class="bg-white shadow border rounded p-2 text-center hover:border-yellow-600 hover:shadow-lg transition duration-200">
    
    <!-- Gambar produk -->
    <img 
      src="img/<?= htmlspecialchars($img_file) ?>" 
      alt="<?= $code ?>" 
      class="w-[102px] h-[50px] object-cover mx-auto mb-1" 
      onerror="this.src='https://via.placeholder.com/102x50?text=Missing';"
    >

    <!-- Kode & harga -->
    <div class="text-sm font-semibold text-gray-800"><?= $code ?></div>
    <div class="text-xs text-rose-700 font-medium mb-1">€<?= $price ?></div>

    <!-- Input jumlah -->
    <input 
      type="number" 
      name="qty[<?= $code ?>]" 
      min="0" 
      value="0" 
      class="w-4/5 h-[54px] border border-pink-400 rounded text-center font-bold text-pink-700"
    >
  </div>
<?php endforeach; ?>

</div>
