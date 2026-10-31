# Sistem Autentikasi Multi-Role — Laravel

Aplikasi autentikasi sederhana berbasis **Laravel** dengan tiga role pengguna: **Admin, Dosen, dan Mahasiswa**.

Project ini dibuat sebagai bagian dari **Tes Seleksi PKL Politeknik Mitra Industri** dengan fokus pada implementasi autentikasi, validasi form, pembatasan akses berdasarkan role, session, dan struktur MVC Laravel.

## Fitur

- Registrasi pengguna
- Pilihan role:
  - Admin
  - Dosen
  - Mahasiswa
- Validasi frontend dan backend
- Validasi email unik
- Validasi password minimal 6 karakter
- Login menggunakan email dan password
- Redirect otomatis berdasarkan role
- Dashboard khusus setiap role
- Proteksi halaman menggunakan middleware
- Akses role yang tidak sesuai menghasilkan **403 Forbidden**
- Logout dan invalidasi session
- Flash message
- Password disimpan menggunakan hashing
- Session regeneration saat login
- Tampilan antarmuka bertema pixel-art

## Teknologi

- **Laravel 12**
- **PHP 8+**
- **MySQL**
- **Blade Template**
- **Laravel Eloquent ORM**
- **Laravel Middleware**
- **Laravel Form Request Validation**
- **HTML, CSS, JavaScript**
- **Laragon** sebagai local development environment

## Prasyarat

Pastikan perangkat sudah memiliki:

- PHP 8+
- Composer
- MySQL
- Laragon atau local development environment lain
- Git

Project ini dikembangkan dan dijalankan menggunakan **Laragon**.

## Cara Setup & Menjalankan

### 1. Clone repository

```bash
git clone https://github.com/USERNAME/multirole-sederhana.git
cd multirole-sederhana
```

Ganti `USERNAME` dengan username GitHub pemilik repository.

### 2. Install dependency

```bash
composer install
```

### 3. Buat file `.env`

Salin file `.env.example` menjadi `.env`.

Windows:

```bash
copy .env.example .env
```

Atau buat file `.env` secara manual.

### 4. Atur koneksi database

Sesuaikan konfigurasi database pada `.env`.

Contoh:

```env
APP_NAME="Multi Role Authentication"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=multirole_sederhana
DB_USERNAME=root
DB_PASSWORD=
```

Pastikan MySQL sudah aktif melalui Laragon.

### 5. Generate application key

```bash
php artisan key:generate
```

### 6. Buat database

Buat database MySQL dengan nama yang sesuai dengan konfigurasi `.env`.

Contoh:

```text
multirole_sederhana
```

### 7. Jalankan migration dan seeder

```bash
php artisan migrate --seed
```

Migration digunakan untuk membuat struktur database, sedangkan seeder menyediakan akun demo untuk pengujian.

### 8. Jalankan aplikasi

```bash
php artisan serve
```

Kemudian buka:

```text
http://127.0.0.1:8000
```

Jika menggunakan Laragon, aplikasi juga dapat dijalankan melalui environment Laragon sesuai konfigurasi virtual host yang tersedia.

---

# Struktur Project

Struktur utama aplikasi:

```text
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── AdminController.php
│   │   │   ├── DosenController.php
│   │   │   └── MahasiswaController.php
│   │   │
│   │   ├── Middleware/
│   │   │   └── ...
│   │   │
│   │   └── Requests/
│   │       └── RegisterRequest.php
│   │
│   ├── Models/
│   │   └── User.php
│   │
│   └── Views/
│       └── ...
│
├── database/
│   ├── migrations/
│   └── seeders/
│
├── public/
│   └── assets/
│
├── resources/
│   └── ...
│
├── routes/
│   └── web.php
│
├── tests/
│   └── Feature/
│
├── .env.example
├── artisan
├── composer.json
└── README.md
```

Laravel menangani routing, controller, model, validation, middleware, session, dan view sesuai pola MVC.

---

# Role & Hak Akses

Aplikasi memiliki tiga role:

### Admin

Admin dapat mengakses:

```text
/admin/dashboard
```

Dashboard menampilkan:

```text
Selamat datang Admin
```

### Dosen

Dosen dapat mengakses:

```text
/dosen/dashboard
```

Dashboard menampilkan:

```text
Selamat datang Dosen
```

### Mahasiswa

Mahasiswa dapat mengakses:

```text
/mahasiswa/dashboard
```

Dashboard menampilkan:

```text
Selamat datang Mahasiswa
```

Setiap dashboard dilindungi oleh autentikasi dan pemeriksaan role.

Jika pengguna belum login, pengguna diarahkan ke halaman login.

Jika pengguna sudah login tetapi mencoba mengakses dashboard milik role lain, aplikasi mengembalikan:

```text
403 Forbidden
```

---

# Authentication

## Register

Halaman:

```text
/register
```

Form registrasi terdiri dari:

- Nama
- Email
- Password
- Role

Role yang diperbolehkan:

```text
admin
dosen
mahasiswa
```

Validasi dilakukan di sisi frontend dan backend.

Validasi backend tetap berjalan meskipun validasi frontend dilewati atau dimanipulasi.

Ketentuan utama:

- Nama wajib diisi
- Email wajib diisi
- Email harus memiliki format yang valid
- Email harus unik
- Password minimal 6 karakter
- Role wajib dipilih
- Role harus termasuk dalam whitelist yang tersedia

Password tidak disimpan dalam bentuk teks biasa, tetapi menggunakan hashing Laravel.

Setelah registrasi berhasil, pengguna diarahkan ke halaman login.

## Login

Halaman:

```text
/login
```

Pengguna melakukan login menggunakan:

- Email
- Password

Setelah login berhasil, pengguna diarahkan sesuai role:

```text
Admin      → /admin/dashboard
Dosen      → /dosen/dashboard
Mahasiswa  → /mahasiswa/dashboard
```

Jika email atau password salah, aplikasi menampilkan:

```text
Email atau password salah
```

## Logout

Logout dilakukan melalui endpoint:

```text
POST /logout
```

Setelah logout, session pengguna dihapus dan pengguna diarahkan kembali ke halaman login.

---

# Akun Demo

Project menyediakan akun demo untuk mempermudah proses pengujian.

| Role | Email | Password |
|---|---|---|
| Admin | `admin@polimind.local` | `Admin123!` |
| Dosen | `dosen@polimind.local` | `Dosen123!` |
| Mahasiswa | `mahasiswa@polimind.local` | `Mahasiswa123!` |

Akun tersebut dapat digunakan untuk melakukan demonstrasi login dan pengujian dashboard berdasarkan role.

---

# Routing Utama

| Method | Route | Akses |
|---|---|---|
| GET | `/register` | Guest |
| POST | `/register` | Guest |
| GET | `/login` | Guest |
| POST | `/login` | Guest |
| GET | `/admin/dashboard` | Admin |
| GET | `/dosen/dashboard` | Dosen |
| GET | `/mahasiswa/dashboard` | Mahasiswa |
| POST | `/logout` | Authenticated User |

Proteksi akses tidak hanya dilakukan pada tampilan.

Pemeriksaan autentikasi dan role dilakukan pada sisi backend menggunakan middleware sehingga pengguna tidak dapat memperoleh akses hanya dengan memanipulasi URL.

---

# Validasi & Security

Beberapa validasi dan mekanisme keamanan yang digunakan:

### Unique Email

Email pengguna harus unik di database.

Jika email sudah digunakan, registrasi akan ditolak.

### Password Hashing

Password pengguna disimpan menggunakan mekanisme hashing Laravel, bukan plaintext.

### Role Whitelist

Role hanya menerima:

```php
admin
dosen
mahasiswa
```

Request dengan role lain akan ditolak oleh validasi backend.

### Session Regeneration

Session diregenerasi setelah login untuk membantu mencegah session fixation.

### Middleware

Dashboard dilindungi menggunakan middleware berdasarkan status login dan role pengguna.

### Backend Validation

Validasi backend tetap menjadi sumber validasi utama sehingga pengguna tidak dapat melewati aturan hanya dengan mematikan atau memanipulasi JavaScript pada browser.

---

# Pengujian Manual

Berikut beberapa skenario yang dapat digunakan untuk menguji aplikasi.

### 1. Register

Buka:

```text
/register
```

Uji:

- Form kosong
- Email tidak valid
- Password kurang dari 6 karakter
- Email yang sudah digunakan
- Role yang valid
- Registrasi berhasil

### 2. Login Salah

Masukkan email atau password yang salah.

Hasil yang diharapkan:

```text
Email atau password salah
```

### 3. Login Admin

Gunakan akun Admin.

Hasil:

```text
/admin/dashboard
```

dan menampilkan:

```text
Selamat datang Admin
```

### 4. Login Dosen

Gunakan akun Dosen.

Hasil:

```text
/dosen/dashboard
```

dan menampilkan:

```text
Selamat datang Dosen
```

### 5. Login Mahasiswa

Gunakan akun Mahasiswa.

Hasil:

```text
/mahasiswa/dashboard
```

dan menampilkan:

```text
Selamat datang Mahasiswa
```

### 6. Akses Tanpa Login

Coba membuka dashboard tanpa login.

Hasil:

```text
Redirect → /login
```

### 7. Akses Role yang Salah

Contoh:

```text
Login sebagai Mahasiswa
↓
Buka /admin/dashboard
```

Hasil:

```text
403 Forbidden
```

### 8. Logout

Klik tombol logout.

Hasil:

```text
Redirect → /login
```

Setelah logout, dashboard tidak dapat diakses kembali tanpa login.

---

# Automated Testing

Project juga memiliki feature test untuk memeriksa beberapa bagian authentication dan registration.

Test dapat dijalankan dengan:

```bash
php artisan test
```

Test mencakup pengujian terhadap alur registrasi dan authentication yang digunakan oleh aplikasi.

---

# Database

Struktur database dikelola menggunakan Laravel Migration.

Seeder digunakan untuk menyediakan akun demo sehingga aplikasi dapat langsung diuji setelah proses setup selesai.

Perintah untuk membuat database dari migration dan menjalankan seeder:

```bash
php artisan migrate --seed
```

Jika ingin mengulang database dari awal:

```bash
php artisan migrate:fresh --seed
```

> Perintah `migrate:fresh` akan menghapus tabel yang ada dan membuat ulang database berdasarkan migration.

---

# MVC Architecture

Project menggunakan pola **Model-View-Controller (MVC)** yang disediakan oleh Laravel.

### Model

Menangani representasi dan interaksi data, seperti:

```text
app/Models/User.php
```

### View

Menangani tampilan halaman menggunakan Blade.

Contohnya:

```text
Login
Register
Admin Dashboard
Dosen Dashboard
Mahasiswa Dashboard
```

### Controller

Menangani request dan alur aplikasi.

Contohnya:

```text
AuthController
AdminController
DosenController
MahasiswaController
```

### Middleware

Digunakan untuk membatasi akses berdasarkan status autentikasi dan role pengguna.

---

# Tampilan

Aplikasi menggunakan konsep visual **pixel-art** dengan tema yang terinspirasi dari interface game, tetapi tetap digunakan sebagai aplikasi autentikasi dan dashboard.

Halaman utama yang tersedia:

- Login
- Register
- Admin Dashboard
- Dosen Dashboard
- Mahasiswa Dashboard
- 403 Forbidden

Halaman register menggunakan visual karakter yang menggambarkan identitas pengguna yang belum ditentukan, sesuai konsep proses registrasi.

---

# Screenshot & Demo

Dokumentasi pengujian dapat mencakup:

1. Halaman Register
2. Validasi Register
3. Halaman Login
4. Login sebagai Admin
5. Dashboard Admin
6. Login sebagai Dosen
7. Dashboard Dosen
8. Login sebagai Mahasiswa
9. Dashboard Mahasiswa
10. Halaman 403 Forbidden
11. Proses Logout

Video demonstrasi digunakan untuk menunjukkan alur authentication, validasi, role-based access, dan logout.

---

# Catatan

File `.env` tidak disertakan dalam repository karena berisi konfigurasi lokal dan kredensial environment.

Gunakan:

```text
.env.example
```

sebagai referensi konfigurasi environment.

Folder dependency seperti:

```text
/vendor
/node_modules
```

juga tidak disertakan dalam repository dan dapat dibuat kembali melalui proses instalasi dependency.

---

# Author

**Ammar Al Hafizd**

Project ini dibuat sebagai bagian dari **Tes Seleksi PKL Politeknik Mitra Industri**.