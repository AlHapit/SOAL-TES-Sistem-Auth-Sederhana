Website Multiple-Sederhana
*credit to politekhnik mitra industri ijin ambil logonya yak

1. Cara Set Up
#Pastikan Requirements berikut sudah tersedia :
- PHP 8.2+
- Composer
- MySQL
- Node
#Masuk ke directory project Jika kamu memakai xampp lakukan ini di terminal
cd C:\xampp\htdocs\multiple-sederhana
#Install dependency laravel
composer install
2.Ganti env.example ke .env lalu konfigurasi ya man teman
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=
*CATATAN : sesuaikan username dan password sesuai dengan konfigurasi MYSQL MASING MASING
#Buka terminal/powershell lalu jalankan : php artisan migrate --seed(I hope nothing goes wrong.)
3.Cara menjalankan
buka powershell/terminal/cmd lalu ketik php artisan serve, kemudian buka http://127.0.0.1:8000
4. Akun Contoh yang sudah disiapkan di seeder
#MAHASISWA
mahasiswa@polimind.local
Mahasiswa123!
#ADMIN
admin@polimind.local
Admin123!
#DOSEN
dosen@polimind.local
Dosen123!

