# Mulai dari sini — Laragon 6

Panduan untuk menjalankan portofolio ini di komputer Windows dengan Laragon 6 dan VS Code. Anda tidak perlu membuat proyek Laravel baru: ZIP ini sudah berisi proyeknya.

## 1. Periksa PHP dan Composer

Buka Laragon 6, lalu klik **Terminal**. Jalankan satu per satu:

```bat
php -v
composer --version
```

Proyek memakai Laravel 12 dan membutuhkan **PHP 8.2 atau lebih baru** serta **Composer 2**. Nomor versi Laragon dan nomor versi PHP adalah dua hal berbeda. Laragon 6 bisa dipakai selama versi PHP yang aktif memenuhi syarat.

Jika PHP sudah 8.2, 8.3, atau 8.4, lanjutkan ke langkah 2.

Jika PHP masih 7.x, 8.0, atau 8.1:

1. Periksa menu Laragon **PHP → Version**. Pilih PHP 8.2 atau 8.3 jika sudah tersedia.
2. Jika belum tersedia, ambil paket PHP Windows **8.3 x64 Thread Safe dalam bentuk ZIP** dari situs resmi https://windows.php.net/download/ . Paket ini sesuai untuk Laragon Windows 64-bit pada umumnya.
3. Ekstrak ke folder tersendiri di `C:\laragon\bin\php\`, misalnya `C:\laragon\bin\php\php-8.3`. Pastikan `php.exe` berada langsung di dalam folder tersebut, bukan di subfolder bertingkat.
4. Buka ulang Laragon, pilih versi tersebut di **PHP → Version**, lalu tutup dan buka ulang Terminal Laragon.
5. Jalankan `php -v` lagi. Gunakan versi yang baru jika sudah tampil.

Jika `composer` tidak dikenali, unduh **Composer-Setup.exe** dari https://getcomposer.org/download/ . Saat installer meminta lokasi PHP, pilih `php.exe` dari versi Laragon yang baru Anda pilih. Selesai instalasi, buka ulang Terminal Laragon dan periksa `composer --version`.

Jika PHP tidak bisa dijalankan karena DLL/Visual C++ yang hilang, simpan teks errornya. Jangan melanjutkan instalasi proyek sebelum `php -v` berhasil.

## 2. Ekstrak proyek

Ekstrak ZIP ke `C:\laragon\www`. Struktur yang benar:

```text
C:\laragon\www\Portofolio\artisan
C:\laragon\www\Portofolio\composer.json
C:\laragon\www\Portofolio\.env.example
C:\laragon\www\Portofolio\app\
C:\laragon\www\Portofolio\public\
```

Jika hasil ekstrak menjadi `Portofolio\Portofolio\artisan`, pindahkan folder proyek yang paling dalam agar `artisan` ada pada lokasi di atas. Jangan menimpa proyek lain atau file `.env` yang sudah Anda gunakan.

Jika Laragon dipasang di drive atau folder lain, ganti `C:\laragon` pada panduan ini sesuai lokasi instalasi Anda.

## 3. Buka di VS Code

Di VS Code, pilih **File → Open Folder**, lalu pilih `C:\laragon\www\Portofolio`.

Untuk menjalankan perintah pada panduan ini, gunakan **Terminal Laragon** terlebih dahulu. Terminal VS Code belum tentu mengenali PHP Laragon jika PATH Windows belum diatur.

## 4. Instal library proyek

Pada Terminal Laragon, jalankan:

```bat
cd /d C:\laragon\www\Portofolio
composer install
```

Perintah `cd /d` di atas untuk CMD/Terminal Laragon. Jika menggunakan PowerShell, gunakan `cd C:\laragon\www\Portofolio`.

Tunggu sampai instalasi selesai tanpa error. Koneksi internet diperlukan pada tahap ini. Folder `vendor` akan dibuat. Tidak perlu menjalankan `composer create-project`, `laravel new`, atau `npm install`.

Jika muncul pesan versi PHP tidak memenuhi syarat, ulangi langkah 1. Jangan menggunakan `--ignore-platform-reqs`, karena itu hanya melewati pemeriksaan dan tidak memperbaiki ketidakcocokan.

## 5. Siapkan konfigurasi dan database

Jalankan satu per satu, hanya saat instalasi pertama pada folder baru:

```bat
copy .env.example .env
php artisan key:generate
php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
php artisan migrate
```

Penjelasan singkat:

- `.env` berisi pengaturan lokal proyek.
- `key:generate` membuat kunci aplikasi.
- Perintah ketiga membuat file database SQLite jika belum ada.
- `migrate` membuat tabel yang dibutuhkan, termasuk tabel pesan kontak.

Pengaturan SQLite sudah tersedia di `.env.example`. Tidak perlu membuka phpMyAdmin, membuat database MySQL, atau mengisi username/password database. Jangan menyalin `.env.example` atau membuat ulang kunci setiap kali ingin menjalankan aplikasi.

Jika muncul `could not find driver`, buka menu Laragon **PHP → php.ini**, aktifkan baris ekstensi berikut dengan menghapus tanda `;` di depannya jika ada:

```ini
extension=pdo_sqlite
extension=sqlite3
```

Simpan, buka ulang Terminal Laragon, lalu ulangi perintah yang gagal. Gunakan `php --ini` jika ingin memastikan file konfigurasi PHP yang sedang dipakai.

## 6. Jalankan website

Masih dari folder proyek, jalankan:

```bat
php artisan serve
```

Buka alamat yang dicetak di terminal menggunakan browser. Ini adalah server lokal pada komputer Anda. Terminal harus tetap terbuka selama website dipakai. Tekan **Ctrl+C** untuk menghentikannya.

Pada alur ini, Apache dan MySQL Laragon tidak harus menyala. Jangan mencoba membuka berkas Blade dengan klik dua kali atau VS Code Live Server: halaman harus dijalankan melalui Laravel.

Jika port sedang dipakai, gunakan:

```bat
php artisan serve --port=8001
```

Pada hari berikutnya, cukup buka Terminal Laragon dan jalankan:

```bat
cd /d C:\laragon\www\Portofolio
php artisan serve
```

## 7. Ganti identitas dan karya contoh

Buka `.env` di VS Code, lalu isi sesuai identitas Anda:

```dotenv
PORTFOLIO_NAME="Nama Anda"
PORTFOLIO_EMAIL=
PORTFOLIO_WHATSAPP=
PORTFOLIO_INSTAGRAM=
PORTFOLIO_GITHUB=
```

Kontak boleh dibiarkan kosong. WhatsApp memakai format internasional, diawali `62` untuk Indonesia dan tanpa tanda `+`. Instagram/GitHub diisi URL lengkap profil milik Anda.

Simpan file, lalu jalankan dari terminal lain pada folder proyek:

```bat
php artisan optimize:clear
```

Refresh browser. Daftar karya dan layanan ada di `config/portfolio.php`. Gambar diletakkan di `public/images`. Semua karya awal adalah konsep demo, dan video aftermovie asli belum disertakan. Ganti materi dan deskripsinya dengan karya sendiri sebelum mengubah `demo` menjadi `false`.

## Pesan kontak dan pengujian

Formulir kontak menyimpan pesan di database. Untuk membacanya, buka terminal lain pada folder proyek:

```bat
php artisan portfolio:messages
php artisan portfolio:messages --id=1
```

Pesan belum otomatis dikirim lewat email. Untuk menjalankan pengujian aplikasi:

```bat
php artisan test
```

Jika salah satu langkah gagal, salin pesan error pada langkah tersebut. Selesaikan error itu terlebih dahulu, lalu lanjutkan; tidak perlu menginstal ulang seluruh proyek.
