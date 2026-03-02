<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


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

