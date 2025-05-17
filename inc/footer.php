<?php
// Pastikan $TEXT tersedia
if (!isset($TEXT)) $TEXT = [];
?>

<!-- Footer -->
<footer class="bg-[#4e342e] text-yellow-400 text-center py-4 mt-10">
  <p class="text-sm">
    <?= $TEXT['maintained_by'] ?? 'Created & Maintained by' ?>
    <a href="https://kutaweb.com" target="_blank" class="hover:text-yellow-300 no-underline">KutaWeb</a>
  </p>
</footer>
