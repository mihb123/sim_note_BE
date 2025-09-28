# 📝 sim_note

A simple **Note-taking API** built with **Laravel**.  
This repository provides the backend for the **sim_note** app.

---

## 📂 Repository
GitHub: [sim_note_BE](https://github.com/mihb123/sim_note_BE.git)

---

## ✨ Features
- Create, update, delete personal notes.
- RESTful JSON API (ready for React or any frontend).
- SQLite (default) or MySQL support.
- Laravel 12 with Eloquent ORM & migrations.

---

## 🚀 Requirements
- PHP ≥ 8.1
- Composer
- SQLite or MySQL
- (Optional) Node.js if you plan to run the React frontend separately.

---

## ⚙️ Setup

```bash
# 1. Clone repository
git clone https://github.com/mihb123/sim_note_BE.git
cd sim_note_BE

# 2. Install dependencies
composer install

# 3. Copy .env and set APP_KEY & DB settings
cp .env.example .env
php artisan key:generate

# For SQLite (default)
touch database/database.sqlite
#   or configure MySQL in .env

# 4. Run migrations
php artisan migrate

# 5. Start local server
php artisan serve

API will be available at http://localhost:8000