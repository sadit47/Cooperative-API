# Cooperative Registration API

REST API สำหรับระบบยื่นคำขอจัดตั้งสหกรณ์ พัฒนาด้วย Laravel 12, MySQL และ Docker โดยออกแบบตามมาตรฐาน REST และรองรับ Role-based access control

---

## 🚀 Features

* Register / Login / Logout ด้วย Laravel Sanctum
* Token-based Authentication (Bearer Token)
* รองรับ 2 Role:

  * `public` (ประชาชน)
  * `staff` (เจ้าหน้าที่)
* Public:

  * ยื่นคำขอจัดตั้งสหกรณ์
  * ดูเฉพาะคำขอของตัวเอง
* Staff:

  * ดูคำขอทั้งหมด
  * กรองคำขอตามสถานะ
  * อนุมัติ / ปฏิเสธ พร้อมระบุเหตุผล
* Validation:

  * ชื่อสหกรณ์ต้องไม่ซ้ำ
  * จำนวนสมาชิก ≥ 10
  * review_note ต้องมีตอน approve/reject
* ป้องกัน Role ไม่ให้เข้าถึง endpoint ของอีก Role
* Response format เป็นมาตรฐานเดียวกันทุก endpoint

---

## 🛠 Tech Stack

* PHP 8.3
* Laravel 12
* MySQL 8
* Laravel Sanctum
* Docker + Docker Compose
* phpMyAdmin

---

## ⚙️ Installation

```bash id="setup1"
git clone https://github.com/sadit47/Cooperative-API.git
cd cooperative-api

cp .env.example .env

docker compose up -d --build

docker compose exec app composer install

docker compose exec app php artisan key:generate

docker compose exec app php artisan migrate
```

---

## 🔧 Environment Configuration

แก้ไขไฟล์ `.env`

```env id="env1"
APP_URL=http://localhost:8090

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=cooperative_db
DB_USERNAME=cooperative_user
DB_PASSWORD=cooperative_pass
```

---

## 🗄 Database Setup

```bash id="db1"
docker compose exec app php artisan migrate:fresh --seed
```

---

---

## 🌐 Live API
```text id="url1"
Deployed on Railway:
https://cooperative-api-production-e09a.up.railway.app
```

---

## 🌐 Local Development

```text id="url1"
API: http://localhost:8090
phpMyAdmin: http://localhost:8089
```

---

## 👤 Seed Users

### Public User

Email: [public@test.com](mailto:public@test.com)
Password: password
Role: public

### Staff User

Email: [staff@test.com](mailto:staff@test.com)
Password: password
Role: staff

---

## 🔑 Authentication

ใช้ Bearer Token

```text id="auth1"
Authorization: Bearer {token}
```

---

## 📡 API Endpoints

### 🔐 Authentication

| Method | Endpoint      | Description            |
| ------ | ------------- | ---------------------- |
| POST   | /api/register | Register               |
| POST   | /api/login    | Login (Public / Staff) |
| POST   | /api/logout   | Logout                 |
| GET    | /api/staff/cooperative-requests  | Public Access Staff Endpoint - Fail (403) |
| GET    | /api/public/cooperative-requests | Staff Access Public Endpoint - Fail (403) |

---

### 👤 Public

| Method | Endpoint                              | Description                                        |
| ------ | ------------------------------------- | -------------------------------------------------- |
| POST   | /api/public/cooperative-requests      | Create Cooperative Request (Success)               |
| POST   | /api/public/cooperative-requests      | Create Cooperative Request (Duplicate Name - Fail) |
| POST   | /api/public/cooperative-requests      | Create Cooperative Request (Members < 10 - Fail)   |
| GET    | /api/public/cooperative-requests      | Get My Cooperative Requests (User A / User B)      |
| GET    | /api/public/cooperative-requests/{id} | Get Request Detail (Other User - Fail)             |

---

### 🧑‍💼 Staff

| Method | Endpoint                                       | Description                                           |
| ------ | ---------------------------------------------- | ----------------------------------------------------- |
| GET    | /api/staff/cooperative-requests                | Get All Cooperative Requests                          |
| GET    | /api/staff/cooperative-requests?status=pending | Filter Requests (Pending)                             |
| PATCH  | /api/staff/cooperative-requests/{id}/approve   | Approve Cooperative Request (Success)                 |
| PATCH  | /api/staff/cooperative-requests/{id}/approve   | Approve Cooperative Request (Already Reviewed - Fail) |
| PATCH  | /api/staff/cooperative-requests/{id}/approve   | Approve Cooperative Request (Missing Note - Fail)     |
| PATCH  | /api/staff/cooperative-requests/{id}/reject    | Reject Cooperative Request (Success)                  |
| PATCH  | /api/staff/cooperative-requests/{id}/reject    | Reject Cooperative Request (Already Reviewed - Fail)  |
| PATCH  | /api/staff/cooperative-requests/{id}/reject    | Reject Cooperative Request (Missing Note - Fail)      |

---

## 📦 Response Format

### ✅ Success

```json id="res1"
{
  "success": true,
  "message": "Success",
  "data": {}
}
```

---

### ❌ Error

```json id="res2"
{
  "success": false,
  "message": "Error message",
  "errors": {}
}
```

---

### ❌ Validation Error

```json id="res3"
{
  "success": false,
  "message": "Validation failed",
  "errors": {
    "field": [
      "error message"
    ]
  }
}
```

---

## 🧪 Postman Collection

ไฟล์อยู่ใน repository:

```text id="pm1"
Cooperative API.postman_collection.json
```

### วิธีใช้งาน

1. เปิด Postman
2. Import → เลือกไฟล์ `.json`
3. ตั้งค่า Environment:

### Local

base_url = http://localhost:8090

public_token =

staff_token =

---

### Production (Railway)

base_url = https://cooperative-api-production-e09a.up.railway.app

---

## 🔄 Testing Flow

1. Login (Public)
2. Create Cooperative Request
3. Test Validation:

   * Duplicate name
   * Members < 10
4. Get My Requests
5. Login (Staff)
6. Get All Requests
7. Approve / Reject
8. Test Review Duplicate
9. Test Role Access (403)

---

## 📌 Summary

โปรเจกต์นี้ครอบคลุม:

* Authentication (Sanctum)
* Authorization (Role-based)
* Validation (Business rules)
* RESTful API Design
* Standardized Response Format

พร้อมสำหรับการส่งประเมินและใช้งานจริง
