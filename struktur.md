/hilos-v2/
x ├── index.php                  # Landing page / halaman awal (pilih bahasa)
x ├── form.php                   # Halaman pilih produk & isi data pelanggan
x ├── confirm.php                # Halaman konfirmasi pesanan
x ├── finalize.php               # Proses akhir, kirim email, redirect
x ├── done.php                     # Halaman akhir (sukses/gagal)
├── .htaccess                    # Optional: redirect & security rules
x ├── logo.png                   # Logo utama
x ├── favicon.ico                # Favicon
x ├── bg-hilos.jpg               # Background image
├── tailwind.css                 # Generated (jika compile offline, tapi ini pakai CDN)
│
x ├── /img/                      # 482 gambar produk benang (.jpg)
│
├── /inc/                        # Include files untuk struktur & logic modular
x │   ├── config.php             # Harga, ongkir, email, IBAN, Bizum, PayPal, branding
x │   ├── header.php             # Header (judul, logo, bg, tailwind link, dsb)
x │   ├── footer.php             # Footer (link & catatan)
x │   ├── product-grid.php       # Komponen produk (looping gambar & input jumlah)
│   ├── customer-form.php        # Komponen form pelanggan (form.php)
│   ├── shipping.php             # Fungsi perhitungan ongkir
│   └── helpers.php              # Fungsi umum (order ID, sanitize, format harga)
│
├── /lang/                       # File bahasa (multilingual system)
│   ├── es.php
│   └── en.php
│
├── /mail/                       # Semua yang terkait email
x │   ├── send_admin.php           # Kirim email ke admin (plain text)
x │   ├── send_customer.php        # Kirim email ke pelanggan (HTML)
x │   ├── template_admin.php       # Template isi email admin
x │   ├── template_customer.php    # Template isi email pelanggan
x │   ├── test_admin.php           # Halaman uji kirim ke admin
x │   └── test_customer.php        # Halaman uji kirim ke pelanggan
│
├── /log/                        # Semua log (email, error, dsb)
│   └── email.log                # Log pengiriman email
├── /assets/
    ├── fonts/                   # jika nanti diperlukan font offline (Poppins/Playfair)
    ├── icons/                   # jika nanti butuh icon SVG custom (opsional)
