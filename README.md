# Cooperative Registration API

REST API สำหรับระบบยื่นคำขอจัดตั้งสหกรณ์ พัฒนาด้วย Laravel + MySQL และ Docker

## Tech Stack

- PHP 8.3
- Laravel
- MySQL 8
- Laravel Sanctum
- Docker
- phpMyAdmin

## Features

- Register / Login / Logout
- Token Authentication ด้วย Laravel Sanctum
- Role-based access control
- Public สามารถยื่นคำขอจัดตั้งสหกรณ์
- Public ดูได้เฉพาะคำขอของตัวเอง
- Staff ดูคำขอทั้งหมด
- Staff กรองคำขอตามสถานะ
- Staff อนุมัติหรือปฏิเสธคำขอ
- คำขอที่ถูก review แล้ว ไม่สามารถ review ซ้ำได้

## Installation

```bash
git clone https://github.com/sadit47/Cooperative-API.git
cd cooperative-api
docker compose up -d --build