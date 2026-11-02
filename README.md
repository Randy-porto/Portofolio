# Randy — Creative & Code

**Menggunakan Laragon 6?** Ikuti [panduan langkah demi langkah dari awal](MULAI-DI-SINI-LARAGON6.md).

Portofolio personal berbasis **Laravel 12 + Blade**, CSS, dan JavaScript murni. Tema editorial gelap dengan aksen lime, tipografi lokal, dan galeri karya responsif. Tidak memerlukan npm, Vite, React, atau layanan frontend eksternal.

## Yang sudah tersedia

- Beranda, profil, bidang pengalaman, layanan, dan kontak dalam bahasa Indonesia.
- Empat konsep karya: foto wisuda, aftermovie, konten brand, dan web development.
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
