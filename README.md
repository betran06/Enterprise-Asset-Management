# 🧾 Sistem Informasi Inventaris Aset Kantor

Proyek ini merupakan **Sistem Informasi Inventaris Aset Berbasis Web** yang dikembangkan menggunakan **Laravel 10**.  
Aplikasi ini dirancang untuk membantu perusahaan dalam **pendataan, pelacakan, penyusutan, dan pelaporan aset kantor**,  
serta mencatat setiap aktivitas perubahan data melalui fitur **Audit Trail**.

---

## 🚀 Fitur Utama

### 🏷️ Manajemen Aset
- Tambah, ubah, hapus, dan cari data aset.
- Aset dikelompokkan berdasarkan **kategori**, **lokasi**, dan **pengguna (karyawan)**.
- Setiap aset memiliki **kode unik (QR Code)** yang dapat discan untuk melihat detailnya.

### 📱 QR Code
- Generate QR Code otomatis berdasarkan `kode_aset`.
- QR disimpan di folder `storage/app/public/qr/` (atau di-generate on-the-fly).
- Fitur **Scan QR** menggunakan kamera perangkat untuk menampilkan detail aset secara langsung.

### 📉 Penyusutan Aset
- Menghitung penyusutan otomatis berdasarkan **metode garis lurus (straight-line)** atau **saldo menurun (declining balance)**.
- Mengacu pada **kelompok harta DJP (Direktorat Jenderal Pajak)**.
- Menyimpan histori penyusutan bulanan dalam tabel `penyusutan_bulanan`.
- Dapat menandai aset **disposed** (rusak, dijual, hibah, hilang, dll).

### 🧍 Manajemen Karyawan
- Menyimpan data pemakai aset (karyawan) lengkap dengan kode, departemen, dan jabatan.
- Aset dapat dikaitkan atau dilepaskan dari karyawan (nullable relationship).
- Jika karyawan dihapus, data aset tetap aman (`ON DELETE SET NULL`).

### 🧠 Audit Trail (Activity Log)
- Menggunakan **Spatie Laravel Activitylog** untuk mencatat semua aktivitas sistem.
- Menyimpan:
  - siapa melakukan apa,
  - waktu kejadian,
  - data sebelum & sesudah perubahan,
  - URL, IP, dan metode HTTP.
- Log utama tersimpan di tabel `activity_log` dan dimirror ke `audit_logs` untuk tampilan UI.

### 🧾 Pelaporan & Feedback
- Modul pelaporan kerusakan aset oleh user.
- Status pelaporan: **Menunggu** / **Selesai**.
- Modul feedback & tanggapan perbaikan dari admin.

### 🔐 Role dan Akses
- Sistem menggunakan middleware custom `CheckRole`.
- Role default: **admin** dan **user**.
- Admin memiliki akses penuh terhadap seluruh modul.

---

## 🛠️ Teknologi yang Digunakan

| Kebutuhan   | Teknologi                         |
|-------------|-----------------------------------|
| Framework   | Laravel 10                        |
| Frontend    | Bootstrap 5, Vite, Axios          |
| Database    | MySQL 8                           |
| QR Code     | endroid/qr-code                   |
| PDF Export  | barryvdh/laravel-dompdf           |
| Notifikasi  | realrashid/sweet-alert            |
| Audit Trail | spatie/laravel-activitylog        |
| Auth & Role | Laravel UI + CheckRole Middleware |
| Dev Tools   | Laravel Pint, Collision, Ignition |

---

## ⚙️ Instalasi

1. **Clone repository**
   ```bash
   git clone https://github.com/username/inventaris-aset.git
   cd inventaris-aset

<=========================================================================>
<=========================================================================>

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
