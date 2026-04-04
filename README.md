# 🚀 Employee Leave Management API

## 📌 Overview

Project ini merupakan RESTful API untuk sistem manajemen cuti karyawan yang dibangun menggunakan Laravel.
API ini memungkinkan karyawan mengajukan cuti dan admin untuk melakukan approval atau rejection.

Fokus utama:

* Clean code structure
* Authentication (Sanctum & OAuth Google)
* Role-based authorization
* Business logic (limit cuti 12 hari)

---

## ⚙️ Tech Stack

* Framework: Laravel
* Authentication: Laravel Sanctum + Google OAuth
* Database: MySQL
* Storage: Laravel Storage (Public Disk)

---

## 🔐 Authentication

Sistem menyediakan 2 metode login:

* Login menggunakan email & password
* Login menggunakan Google OAuth

---

## 👤 Roles & Authorization

### Employee

* Mengajukan cuti
* Melihat riwayat cuti sendiri

### Admin

* Melihat semua pengajuan cuti
* Approve / Reject cuti

---

## 📝 Leave Request Flow

1. Employee mengajukan cuti
2. Status otomatis **pending**
3. Admin:

   * Approve → status menjadi **approved**
   * Reject → status menjadi **rejected**

---

## ⚠️ Business Logic

* Setiap karyawan memiliki limit cuti **12 hari per tahun**
* Sistem akan menolak:

  * Pengajuan yang melebihi limit
  * Approval yang menyebabkan limit terlampaui
* Tidak bisa:

  * Approve / Reject lebih dari sekali

---

## 📂 Attachment

* File wajib diupload saat pengajuan cuti
* Format: PDF, JPG, PNG
* Maksimal ukuran: 2MB
* Disimpan di storage public

---

## 📌 API Endpoints

### Authentication

* POST /api/register
* POST /api/login
* GET /api/auth/google

---

### Leave Requests

* POST /api/leave-requests
* GET /api/my-leaves
* GET /api/leave-requests (admin only)
* PATCH /api/leave-requests/{id}/approve
* PATCH /api/leave-requests/{id}/reject

---

## 🧪 Postman Documentation

👉 (Masukkan link Postman kamu di sini)

---

## ⚙️ Installation

```bash
git clone <repository-url>
cd project-folder
composer install
cp .env.example .env
php artisan key:generate
```

---

## 🔧 Setup Environment

Atur database di file `.env`:

```env
DB_DATABASE=your_db
DB_USERNAME=root
DB_PASSWORD=
```

---

## ▶️ Run Project

```bash
php artisan migrate
php artisan storage:link
php artisan serve
```

---

## 📎 Notes

* Pastikan sudah menjalankan:

  ```bash
  php artisan storage:link
  ```
* Digunakan untuk mengakses file attachment

---

## 👨‍💻 Author

Dibuat oleh: **[Nama Kamu]**
