# Randy — Creative & Code

**Menggunakan Laragon 6?** Ikuti [panduan langkah demi langkah dari awal](MULAI-DI-SINI-LARAGON6.md).

Portofolio personal berbasis **Laravel 12 + Blade**, CSS, dan JavaScript murni. Tema editorial gelap dengan aksen lime, tipografi lokal, dan galeri karya responsif. Tidak memerlukan npm, Vite, React, atau layanan frontend eksternal.

## Yang sudah tersedia

- Beranda, profil, bidang pengalaman, layanan, dan kontak dalam bahasa Indonesia.
- Empat konsep karya: foto wisuda, aftermovie, konten brand, dan web development.
- Setiap karya berisi enam visual orisinal yang dibuat dengan AI sesuai temanya: total 24 gambar, siap untuk mencoba scroll horizontal.
- Klik kartu untuk membuka gambar yang sama di halaman detail; enam thumbnail detail juga bisa dipilih tanpa JavaScript.
- Galeri terpisah berurutan: Fotografi → Film & video → Development → Konten kreatif.
- Setiap kategori memakai baris horizontal; bisa digeser saat jumlah kartu melebihi lebar layar, dengan panah, sentuhan, atau tombol keyboard.
- Thumbnail 1:1 untuk fotografi, development, dan konten; 9:16 untuk video. Lebar kartu tetap agar tidak memenuhi layar.
- Filter kategori yang juga berfungsi tanpa JavaScript; URL filter bisa dibagikan.
- Halaman detail karya, navigasi karya berikutnya, dan halaman 404/429.
- Formulir kontak dengan CSRF, validasi server, honeypot, dan batas 5 pengiriman per menit per IP.
- Pesan disimpan di database; dibaca melalui perintah Artisan lokal. **Belum ada pengiriman email otomatis maupun dashboard admin.**
- Font, gambar, CSS, dan JS lokal. Tidak ada ketergantungan CDN saat membuka web.
- Rekomendasi ekstensi dan task VS Code; pengujian otomatis GitHub Actions untuk PHP 8.2, 8.3, dan 8.4.

**Identitas sementara adalah Randy. Seluruh proyek diberi label konsep demo, bukan klaim riwayat klien. Ganti dengan karya, foto, video, dan pengalaman asli sebelum dipublikasikan. Halaman aftermovie saat ini menampilkan konsep, belum memutar video.**

## Menjalankan di Windows: Laragon + VS Code

### 1. Siapkan alat

Gunakan Laragon dengan **PHP 8.2 atau lebih baru**, Composer 2, dan VS Code. Aktifkan ekstensi PHP `ctype`, `curl`, `dom`, `fileinfo`, `mbstring`, `openssl`, `pdo_sqlite`, `sqlite3`, `tokenizer`, `xml`, dan `zip`. Biasanya sudah tersedia dalam paket PHP Laragon; cek melalui `php -m`.

Simpan folder proyek ini ke `C:\laragon\www\Portofolio`, lalu buka folder tersebut di VS Code. Gunakan **Terminal Laragon** agar PHP dan Composer dari Laragon tersedia. Alternatifnya, tambahkan PHP dan Composer Laragon ke PATH lalu mulai ulang VS Code.

### 2. Instal dependensi dan konfigurasi

Jalankan dari folder proyek. Perintah `copy` berikut bekerja di CMD maupun PowerShell. Salin `.env` **hanya saat pertama kali**, agar konfigurasi yang sudah Anda isi tidak tertimpa.

```powershell
cd C:\laragon\www\Portofolio
composer install
copy .env.example .env
php artisan key:generate
php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
php artisan migrate
php artisan serve
```

Buka alamat yang dicetak oleh `php artisan serve` di browser. Server harus tetap berjalan selama pengembangan. Dengan SQLite bawaan, Anda tidak perlu menyalakan MySQL atau membuat database secara manual. Jalankan `code .` untuk membuka proyek di VS Code jika command tersebut tersedia.

Anda juga dapat menjalankan server dari **Terminal → Run Task → Laravel: jalankan server** di VS Code.

### 3. Jika ingin memakai Apache Laragon

Buat virtual host Laragon dengan **DocumentRoot mengarah ke `C:/laragon/www/Portofolio/public`**, bukan folder utama proyek. Aktifkan `mod_rewrite` dan `AllowOverride All` agar `public/.htaccess` bekerja, lalu reload Apache. Sesuaikan `APP_URL` di `.env` dengan domain lokal virtual host Anda. Cara `php artisan serve` di atas tidak membutuhkan konfigurasi virtual host.

### Opsional: MySQL Laragon

SQLite sudah cukup untuk portofolio ini. Jika ingin MySQL, nyalakan MySQL di Laragon, buat database `portfolio`, aktifkan `pdo_mysql`, lalu ubah `.env` sesuai kredensial lokal Anda:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=portfolio
DB_USERNAME=nama_pengguna_lokal
DB_PASSWORD=kata_sandi_lokal
```

Kemudian jalankan `php artisan config:clear` dan `php artisan migrate`. Pesan yang sudah ada di SQLite tidak otomatis berpindah ke MySQL.

## Mengubah isi portofolio

| Kebutuhan | Lokasi |
| --- | --- |
| Nama dan kontak | `.env`, variabel `PORTFOLIO_*` |
| Intro, layanan, kategori, dan daftar karya | `config/portfolio.php` |
| Gambar karya | `public/images/` |
| Tampilan beranda dan pengalaman | `resources/views/portfolio.blade.php` |
| Tampilan detail karya | `resources/views/project.blade.php` |
| Navigasi dan footer | `resources/views/layouts/app.blade.php` |
| Warna, font, tata letak, responsivitas | `public/css/portfolio.css` |
| Ukuran kartu dan baris galeri horizontal | `public/css/gallery.css` |
| Panah dan navigasi keyboard galeri | `public/js/gallery.js` |
| Filter, menu ponsel, shortcut layanan | `public/js/portfolio.js` |

Contoh pengisian identitas (gunakan data milik Anda):

```dotenv
PORTFOLIO_NAME="Nama Anda"
PORTFOLIO_EMAIL=
PORTFOLIO_WHATSAPP=
PORTFOLIO_INSTAGRAM=
PORTFOLIO_GITHUB=
```

Nomor WhatsApp memakai format internasional tanpa `+`, misalnya awalan `62`. Instagram dan GitHub diisi URL profil lengkap dengan `https://`. Kontak yang kosong tidak ditampilkan, sehingga tidak ada tautan menuju akun palsu. Setelah mengubah `.env`, jalankan:

```sh
php artisan optimize:clear
```

Untuk menambah karya, salin satu entri pada `projects` di `config/portfolio.php`. Gunakan slug unik, kategori yang tersedia, dan path gambar relatif terhadap `public`. Ubah `demo` menjadi `false` setelah benar-benar mengganti seluruh materi dengan proyek asli. Label dan penjelasan demo mengikuti nilai ini. Metadata seperti tahun, peran, tools, deskripsi, pendekatan, dan hasil disunting di entri yang sama.

Karya baru otomatis masuk ke baris kategorinya. Saat ini ada satu karya demo per kategori dengan enam gambar berbeda untuk setiap karya. Karena setiap baris berisi enam kartu, scroll dan tombol panah langsung bisa dicoba pada desktop maupun ponsel. Jumlah karya dan jumlah gambar dihitung terpisah: empat karya, 24 gambar. Di ponsel, geser dengan sentuhan. Di komputer, gunakan panah atau trackpad; saat baris mendapat fokus, tombol ←/→ menggeser satu kartu dan Home/End menuju awal/akhir koleksi. Filter hanya menampilkan koleksi yang dipilih; **Semua karya** menampilkan keempat koleksi.

Atur rasio per kategori di bagian `gallery` pada `config/portfolio.php`: `format => 'square'` untuk 1:1 atau `format => 'portrait'` untuk 9:16. Gambar sumber tetap tersimpan dalam ukuran aslinya; rasio ini berlaku pada thumbnail galeri. Preview development memakai `contain` agar seluruh mockup tetap terlihat.

Setiap proyek dapat mempunyai array `visuals`. Untuk menambahkan foto milik sendiri, simpan file ke `public/images` dan tambahkan misalnya:

```php
'visuals' => [
    ['image' => 'images/wisuda-01.jpg', 'caption' => 'Portrait wisuda', 'alt' => 'Deskripsi foto pertama'],
    ['image' => 'images/wisuda-02.jpg', 'caption' => 'Bersama teman', 'alt' => 'Deskripsi foto kedua'],
],
```

Gambar demo AI disimpan sebagai empat lembar berisi enam visual (grid 3 × 2) di `public/images/demo`. Properti `tile` bernilai `0`–`5` memilih bagian gambar melalui CSS; tidak ada duplikasi file besar untuk tiap kartu. Urutannya: kiri atas, tengah atas, kanan atas, kiri bawah, tengah bawah, kanan bawah. Untuk foto biasa, cukup hilangkan `tile`. Jika tidak ada `visuals`, gambar utama `image` proyek tetap dapat ditampilkan. Halaman detail mengikuti pilihan `?gambar=1` sampai `?gambar=6`.

Video asli belum disertakan; untuk aftermovie, tambahkan file atau embed karya milik sendiri pada halaman detail. Tidak ada tombol play palsu atau video yang mengaku sebagai karya pemilik.

## Membaca pesan kontak

Pesan tidak dipublikasikan melalui URL web dan tidak otomatis dikirim lewat email. Pemilik proyek membacanya dari terminal yang memiliki akses aplikasi dan database:

```sh
php artisan portfolio:messages
php artisan portfolio:messages --limit=50
php artisan portfolio:messages --id=1
```

Simpan backup database dan jangan membagikannya karena berisi data kontak pengunjung. SQLite disimpan dalam `database/database.sqlite` dan diabaikan Git. File `.env` juga tidak masuk Git.

## Pengujian

```sh
php artisan test
php artisan view:cache
php artisan view:clear
```

Pengujian mencakup beranda, seluruh detail karya, filter server, 404, penyimpanan pesan, input tidak valid, batas panjang pesan, honeypot, rate limit, escaping input, dan inbox CLI. Task **Laravel: jalankan pengujian** juga tersedia di VS Code.

## Catatan deployment

Untuk produksi, gunakan PHP 8.2+, arahkan web root ke `public`, aktifkan HTTPS, set `APP_ENV=production` dan `APP_DEBUG=false`, lalu jalankan `php artisan migrate --force` serta `php artisan optimize`. Folder `storage` dan `bootstrap/cache` harus dapat ditulis oleh server. Pertahankan `APP_KEY` saat memperbarui instalasi yang sudah digunakan. Jangan unggah `.env`, database, atau log ke repositori publik. Hosting dan publikasi belum dilakukan oleh proyek ini.

## Lingkungan cloud saat ini

PHP 8.4 dan Composer dipasang di luar checkout, pada `/workspace/.tools/bin`. Jika terminal cloud belum menemukan PHP, gunakan `export PATH=/workspace/.tools/bin:$PATH`. Dependensi sudah terpasang pada `vendor/`; cache Composer lokal tersedia pada `/workspace/.tools/composer-cache`. Hal ini hanya untuk cloud, bukan prasyarat Windows/Laragon.

Lisensi dan sumber aset demo tercatat di [THIRD_PARTY_NOTICES.md](THIRD_PARTY_NOTICES.md).
