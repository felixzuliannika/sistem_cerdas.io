# Mood-Based Film Recommendation System

Sistem rekomendasi film berbasis mood yang dibangun menggunakan PHP Native (tanpa framework) dengan database MySQL. Sistem ini memungkinkan pengguna untuk mengisi kuesioner mood interaktif untuk mendapatkan rekomendasi film otomatis melalui sistem rule-based.

## Fitur Utama

- ✅ **Kuesioner Mood Interaktif**
  - Pilihan mood: Energi, Tenang, Galau, Bahagia, Romantis, Semangat
  - Pengaturan tingkat energi (1-5)
  - Pemilihan platform preferensi (Netflix, Prime Video, Vidio, dll)

- ✅ **Sistem Rekomendasi Rule-Based**
  - Filter film berdasarkan mood dan tingkat energi
  - Toleransi energi level untuk fleksibilitas rekomendasi
  - Menampilkan hingga 12 rekomendasi terbaik

- ✅ **Tampilan Film**
  - Thumbnail untuk setiap film
  - Informasi lengkap (judul, genre, tahun, deskripsi)
  - Link langsung ke platform streaming

- ✅ **Fitur Berbagi**
  - Tombol share untuk setiap film
  - Toast notification saat link berhasil disalin

- ✅ **Modul Admin**
  - Sistem login yang aman
  - CRUD lengkap untuk data film
  - Manajemen 60+ film dengan thumbnail

- ✅ **Desain Modern & Responsif**
  - Bootstrap 5 untuk UI framework
  - Animasi dekoratif di sisi kiri-kanan halaman
  - Desain responsif untuk semua perangkat
  - jQuery untuk interaktivitas

## Persyaratan Sistem

- XAMPP (PHP 7.4+ dan MySQL 5.7+)
- Web browser modern (Chrome, Firefox, Edge, Safari)
- Tidak memerlukan Composer atau dependency tambahan

## Instalasi

### 1. Clone atau Download Project

```bash
# Jika menggunakan Git
git clone <repository-url>
cd mood-based-film-recommendation

# Atau extract file ZIP ke folder htdocs XAMPP
```

### 2. Letakkan di XAMPP

Copy folder project ke:
```
C:\xampp\htdocs\mood-based-film-recommendation
```

### 3. Import Database

1. Buka phpMyAdmin: `http://localhost/phpmyadmin`
2. Buat database baru (opsional, atau gunakan yang ada di SQL file)
3. Import file `database.sql`:
   - Klik tab "Import"
   - Pilih file `database.sql`
   - Klik "Go"

Atau jalankan SQL file langsung melalui phpMyAdmin SQL tab.

### 4. Konfigurasi Database

Edit file `config.php` jika diperlukan (default sudah sesuai untuk XAMPP):

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');  // Kosong untuk XAMPP default
define('DB_NAME', 'mood_film_recommendation');
```

### 5. Setup Admin Password (Opsional)

Jika password admin tidak berfungsi, akses:
```
http://localhost/mood-based-film-recommendation/setup_admin.php
```

Default credentials:
- **Username:** `admin`
- **Password:** `admin123`

⚠️ **PENTING:** Hapus atau rename file `setup_admin.php` setelah setup untuk keamanan!

### 6. Akses Aplikasi

**Halaman Utama (User):**
```
http://localhost/mood-based-film-recommendation/
```

**Admin Login:**
```
http://localhost/mood-based-film-recommendation/admin_login.php
```

## Struktur File

```
mood-based-film-recommendation/
│
├── index.php                 # Halaman utama dengan kuesioner
├── recommendations.php       # Halaman hasil rekomendasi
├── config.php                # Konfigurasi database
├── database.sql              # File SQL untuk import database
│
├── admin_login.php           # Halaman login admin
├── admin_dashboard.php       # Dashboard admin untuk CRUD
├── admin_logout.php          # Logout admin
├── api_films.php             # API endpoint untuk CRUD film
├── setup_admin.php           # Setup/reset password admin
│
├── assets/
│   ├── css/
│   │   └── style.css         # Styling dan animasi
│   └── js/
│       ├── main.js           # JavaScript untuk user interface
│       └── admin.js          # JavaScript untuk admin panel
│
└── README.md                 # Dokumentasi ini
```

## Cara Menggunakan

### Untuk Pengguna

1. Buka halaman utama
2. Pilih mood yang sesuai dengan perasaan Anda (dengan icon baru yang lebih menarik)
3. Atur tingkat energi menggunakan slider (1-5)
4. Pilih platform streaming preferensi
5. Klik "Dapatkan Rekomendasi"
6. Lihat hasil rekomendasi film dengan thumbnail yang di-generate otomatis
7. Klik "Cari di [Platform]" untuk membuka beranda platform (link tidak bisa langsung ke film spesifik karena keterbatasan API)
8. Gunakan tombol "Bagikan" untuk menyalin link film

### Untuk Admin

1. Login di `admin_login.php`
2. Akses dashboard admin
3. **Tambah Film:**
   - Klik "Tambah Film"
   - Isi field wajib: judul, mood, energi, platform, URL platform
   - **Thumbnail:** Bisa diisi URL gambar, atau biarkan kosong untuk auto-generate berdasarkan judul dan mood
   - Field opsional: genre, tahun, deskripsi
   - Klik "Simpan"

4. **Edit Film:**
   - Klik tombol edit (ikon pensil) pada film yang ingin diedit
   - Ubah data yang diperlukan
   - Klik "Simpan"

5. **Hapus Film:**
   - Klik tombol hapus (ikon trash) pada film yang ingin dihapus
   - Konfirmasi penghapusan

## Sistem Rekomendasi

Sistem menggunakan **rule-based filtering** dengan logika:

1. **Mood Matching:** Film harus memiliki mood yang sama dengan pilihan user
2. **Energy Level Tolerance:** Film dengan energy level ±1 dari pilihan user akan ditampilkan
3. **Platform Filtering:** Jika user memilih platform spesifik, hanya film dari platform tersebut yang ditampilkan
4. **Ranking:** Film diurutkan berdasarkan:
   - Kedekatan energy level dengan pilihan user
   - Random untuk variasi

## Mood Categories

- **Energi** (Energy Level 4-5): Film action, thriller, high-energy
- **Tenang** (Energy Level 1-2): Film drama, contemplative, slow-paced
- **Galau** (Energy Level 1-3): Film drama, emotional, melancholic
- **Bahagia** (Energy Level 2-4): Film komedi, feel-good, uplifting
- **Romantis** (Energy Level 1-3): Film romance, love stories
- **Semangat** (Energy Level 3-5): Film inspirational, motivational, sports

## Platform yang Didukung

- Netflix
- Prime Video
- Vidio
- Disney+
- HBO Max
- Semua Platform (menampilkan dari semua platform)

## Keamanan

- ✅ Password admin di-hash menggunakan PHP `password_hash()`
- ✅ Session-based authentication untuk admin
- ✅ SQL injection protection menggunakan prepared statements
- ✅ XSS protection dengan `htmlspecialchars()`
- ⚠️ **PENTING:** Hapus `setup_admin.php` setelah setup di production!

## Troubleshooting

### Database Connection Error
- Pastikan MySQL service di XAMPP sudah running
- Periksa konfigurasi di `config.php`
- Pastikan database sudah di-import

### Admin Login Tidak Berfungsi
- Jalankan `setup_admin.php` untuk reset password
- Pastikan password di database menggunakan hash yang benar

### Thumbnail Tidak Muncul
- Thumbnail akan di-generate otomatis jika URL kosong atau tidak valid
- Thumbnail auto-generate menggunakan warna sesuai mood film
- Jika masih tidak muncul, periksa koneksi internet dan console browser
- Admin bisa input URL thumbnail manual atau biarkan kosong untuk auto-generate

### Rekomendasi Tidak Muncul
- Pastikan ada film di database dengan mood dan energy level yang sesuai
- Periksa filter platform yang dipilih
- Coba dengan kombinasi mood/energi/platform yang berbeda

## Teknologi yang Digunakan

- **Backend:** PHP 7.4+ (Native, tanpa framework)
- **Database:** MySQL 5.7+
- **Frontend:** HTML5, CSS3, JavaScript
- **UI Framework:** Bootstrap 5.3.0
- **JavaScript Library:** jQuery 3.7.0
- **Icons:** Bootstrap Icons 1.10.0

## Lisensi

Project ini dibuat untuk keperluan edukasi dan personal use.

## Kontribusi

Silakan fork, modify, dan gunakan sesuai kebutuhan Anda. Jika menemukan bug atau ingin menambahkan fitur, silakan buat issue atau pull request.

## Catatan

- Pastikan XAMPP sudah terinstall dan running
- Database akan otomatis dibuat saat import `database.sql`
- Default admin password: `admin123` (ubah setelah setup!)
- File `setup_admin.php` sebaiknya dihapus setelah setup untuk keamanan
- **Thumbnail:** Sistem akan auto-generate thumbnail jika URL kosong, menggunakan warna sesuai mood
- **Link Platform:** Link hanya mengarah ke beranda platform karena Netflix/Prime Video tidak menyediakan deep link langsung ke film tanpa API resmi mereka

---

**Selamat menggunakan Mood-Based Film Recommendation System! 🎬🎭**

