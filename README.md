# 🗳️ be-qvote

**be-qvote** is a REST API built with **Laravel** for creating and managing surveys, polls, and collecting user responses.  
It features **Telegram authentication** and **Swagger (OpenAPI 3) documentation**.

---

## ⚙️ Features

- Create, update, and manage surveys and polls  
- Collect votes and track responses  
- User authentication via Telegram  
- Auto-generated Swagger documentation  
- Docker-based deployment  
- Optimized production build with `composer install --no-dev --optimize-autoloader`

---

## 🧱 Tech Stack

- **PHP 8.4 (FPM)**  
- **Laravel 11+**  
- **Composer 2.x**  
- **MySQL 8**  
- **Swagger (L5-Swagger)**  
- **Docker**

---

## 🚀 Quick Start

### 1. Clone the repository

```bash
git clone https://github.com/silentias/be-qvote.git
cd be-qvote
```

2. Create .env file

Docker automatically copies .env.example during build, but you can create it manually:

cp .env.example .env

Update the following variables

---

### Docker Setup

Build the container

```bash
docker build -t be-qvote .
```

Run the container

```bash
docker run -p 8000:8000 be-qvote
```

The API will be accessible at: http://localhost:8000

---

## 🧾 Swagger Documentation

Swagger UI is auto-generated using l5-swagger.
Access it at:

👉 http://localhost:8000/api/documentation

---

## 📄 License

This project is licensed under MIT.
Feel free to use and modify it as needed.

---
