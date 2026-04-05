# 🚀 Employee Leave Management API

## 📌 Overview

Project ini merupakan RESTful API untuk sistem manajemen cuti karyawan yang dibangun menggunakan Laravel.
API ini memungkinkan karyawan mengajukan cuti dan admin untuk melakukan approval atau rejection.

Fokus utama:

- Clean code structure
- Authentication (Sanctum & OAuth Google)
- Role-based authorization
- Business logic (limit cuti 12 hari)

---

## ⚙️ Tech Stack

- Framework: Laravel
- Authentication: Laravel Sanctum + Google OAuth
- Database: MySQL
- Storage: Laravel Storage (Public Disk)

---

## 🔐 Authentication

Sistem menyediakan 2 metode login:

- Login menggunakan email & password
- Login menggunakan Google OAuth

---

## 👤 Roles & Authorization

### Employee

- Mengajukan cuti
- Melihat riwayat cuti sendiri

### Admin

- Melihat semua pengajuan cuti
- Approve / Reject cuti

---

## 📝 Leave Request Flow

1. Employee mengajukan cuti
2. Status otomatis **pending**
3. Admin:
    - Approve → status menjadi **approved**
    - Reject → status menjadi **rejected**

---

## ⚠️ Business Logic

- Setiap karyawan memiliki limit cuti **12 hari per tahun**
- Sistem akan menolak:
    - Pengajuan yang melebihi limit
    - Approval yang menyebabkan limit terlampaui

- Tidak bisa:
    - Approve / Reject lebih dari sekali

---

## 📂 Attachment

- File wajib diupload saat pengajuan cuti
- Format: PDF, JPG, PNG
- Maksimal ukuran: 2MB
- Disimpan di storage public

---

## 📌 API Endpoints

### Authentication

- POST /api/register
- POST /api/login

---

### Leave Requests

- POST /api/leave-requests
- GET /api/leave-requests/my
- GET /api/leave-requests (admin only)
- PATCH /api/leave-requests/{id}/approve
- PATCH /api/leave-requests/{id}/reject

---

## 🔐 OAuth Flow (Google)

1. Akses endpoint melalui browser:
   http://127.0.0.1:8000/api/auth/google

2. User akan diarahkan ke halaman login Google

3. Setelah berhasil login, sistem akan redirect ke:
   /api/auth/google/callback

4. API akan mengembalikan:
   - Data user
   - Token authentication

5. Gunakan token tersebut untuk mengakses API melalui Postman
---



## 🔁 Leave Request Full Flow (End-to-End)

Berikut alur lengkap penggunaan API mulai dari registrasi hingga approval oleh admin:

---

### 🟢 1. Register (Employee)

Endpoint:
POST /api/register

Request:
{
  "name": "User Test",
  "email": "user@test.com",
  "password": "password123"
}

---

### 🔐 2. Login (Employee)

Endpoint:
POST /api/login

Request:
{
  "email": "user@test.com",
  "password": "password123"
}

Response:
{
  "message": "Login berhasil",
  "token": "1|xxxxx"
}

➡️ Simpan token untuk digunakan pada request berikutnya

---

### 🔑 3. Set Authorization (Postman)

Gunakan token pada header:

Authorization: Bearer TOKEN_LOGIN

---

### 📝 4. Ajukan Cuti

Endpoint:
POST /api/leave-requests

Body (form-data):
- start_date: 2026-04-05
- end_date: 2026-04-06
- reason: Liburan
- attachment: file (PDF/JPG/PNG)

---

### 📄 5. Lihat Riwayat Cuti (Employee)

Endpoint:
GET /api/leave-requests/my

---

### 🧑‍💼 6. Login Admin

Gunakan akun dari seeder:

Email: admin@test.com  
Password: admin123  

Endpoint:
POST /api/login

➡️ Ambil token admins

---

### 📋 7. Lihat Semua Pengajuan (Admin)

Endpoint:
GET /api/leave-requests

---

### ✅ 8. Approve Cuti

Endpoint:
PATCH /api/leave-requests/{id}/approve

Contoh:
PATCH /api/leave-requests/1/approve

Response:
{
  "message": "Cuti disetujui"
}

---

### ❌ 9. Reject Cuti

Endpoint:
PATCH /api/leave-requests/{id}/reject

Contoh:
PATCH /api/leave-requests/1/reject

Response:
{
  "message": "Cuti Ditolak"
}


---

## ⚠️ Catatan
- File attachment wajib diupload saat pengajuan cuti
- Maksimal cuti: 12 hari per tahun
- Tidak bisa approve/reject lebih dari sekali

---

## 🧪 Postman Documentation

Berikut dokumentasi API lengkap:

https://documenter.getpostman.com/view/50481330/2sBXiqDoMv


---

## ⚙️ Installation

```bash
git clone https://github.com/rifqyfakhryzain/employee-leave-management-system.git
cd employee-leave-management-system
composer install
cp .env.example .env
php artisan key:generate
```

---

## 🔧 Setup Environment

Atur database di file `.env`:

```env
DB_DATABASE=cuti_karyawan
DB_USERNAME=root
DB_PASSWORD=
```
---

## 🔐 OAuth Setup (Google)

Tambahkan konfigurasi berikut di file `.env`:

```env
GOOGLE_CLIENT_ID=844432569224-3nlo91mul9vfssdpmtageq3tf81qu0rp.apps.googleusercontent.com
GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/api/auth/google/callback
```

---

## ▶️ Run Project

```bash
php artisan migrate --seed
php artisan storage:link
php artisan serve

```

## 🌱 Seeder (Admin Account)

Project ini menyediakan seeder untuk membuat akun admin secara otomatis.

Jalankan perintah berikut:

```bash
php artisan db:seed
```

### 🔑 Default Admin Account

* Email: admin@test.com
* Password: admin123

Admin dapat:

* Melihat semua pengajuan cuti
* Melakukan approve / reject


---

## 📎 Notes

- Pastikan sudah menjalankan:

    ```bash
    php artisan storage:link
    ```

- Digunakan untuk mengakses file attachment

---

## 👨‍💻 Author

Dibuat oleh: **RIFQY FAKHRY ZAIN**
