<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


# 🧾 Enterprise Asset Management System

Enterprise Asset Management System (EAMS) is a web-based application developed using Laravel 10 to manage company office assets efficiently and securely.

This system provides comprehensive asset registration, QR code tracking, depreciation calculation, audit trail logging, and role-based access control. It is designed to support asset lifecycle management, compliance monitoring, and structured reporting within an organization.

---

## 🚀 Core Features

### 🏷️ Asset Management
- Create, update, delete, and search asset records.
- Assets are categorized by **category**, **location**, and **assigned employee**.
- Each asset is assigned a unique **Asset Code**.
- Full asset lifecycle management from acquisition to disposal.

---

### 📱 QR Code Integration
- Automatic QR Code generation based on `asset_code`.
- QR codes stored in `storage/app/public/qr/` or generated dynamically.
- Built-in QR Scanner feature to instantly display asset details.
- Quick asset verification using device camera.

---

### 📉 Asset Depreciation
- Automatic depreciation calculation using:
  - **Straight-Line Method**
  - **Declining Balance Method**
- Based on Indonesian Tax Office (DJP) asset classification.
- Monthly depreciation records stored in `monthly_depreciations` table.
- Tracks asset book value over time.
- Supports asset disposal (damaged, sold, donated, lost, etc.).

---

### 🧍 Employee Management
- Store employee information (code, department, position).
- Assets can be assigned/unassigned to employees (nullable relationship).
- If an employee is deleted, related asset data remains safe (`ON DELETE SET NULL`).

---

### 🧠 Audit Trail (Activity Logging)
- Implemented using **Spatie Laravel Activitylog**.
- Logs:
  - User who performed the action
  - Timestamp
  - Data before and after modification
  - URL, IP address, HTTP method
- Primary logs stored in `activity_log`.
- Mirrored into `audit_logs` for reporting and UI display.
- Ensures transparency and accountability.

---

### 🧾 Reporting & Feedback
- Asset damage reporting module.
- Report status: **Pending** / **Resolved**.
- Admin repair feedback system.
- Export reports to PDF.
- Dashboard summary & monitoring.

---

## 🔐 Roles & Access Control

The system uses custom `CheckRole` middleware for role-based authorization.

### 👑 Admin
- Full system access
- Manage assets, employees, users, and roles
- Configure depreciation settings
- View and export audit trail logs
- Manage reports and feedback

### 👨‍💼 Manager
- View asset data and summary reports
- Monitor depreciation values
- Review damage reports
- Access dashboard analytics

### 👨‍🔧 Staff
- Register new assets
- Update asset status
- Scan QR codes
- Submit damage reports
- View assigned assets

### 🔎 Auditor
- Read-only access to:
  - Asset data
  - Depreciation reports
  - Audit trail logs
- Generate audit reports
- Monitor compliance and asset changes

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

👨‍💻 Author

Betran Arya Pramuja
Backend Developer | Laravel Enthusiast

---
## ⚙️ Instalasi

1. **Clone repository**
   ```bash
   git clone https://github.com/username/inventaris-aset.git
   cd inventaris-aset

<=========================================================================>
<=========================================================================>

