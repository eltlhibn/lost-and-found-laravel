# Lost & Found System (Laravel)

A web application where users report lost or found items, and the rightful owner is confirmed through a **verification question** before the item is returned. Built with Laravel 12, Eloquent ORM, Blade templates and MySQL.

> This is the Laravel version of a system I also built in plain PHP: [lost-and-found-php](https://github.com/eltlhibn/lost-and-found-php). Same functionality, two approaches (plain PHP vs. a framework).

## Features

**Users**
- Register, log in and log out (Laravel authentication, hashed passwords)
- Create **lost** or **found** reports with description, location, date, contact info and photo
- Add a **verification question** that only the real owner can answer
- Browse all reports on the dashboard
- Submit an answer to a report's verification question
- Review answers on your own reports (correct / reject)
- Edit, delete or mark your own reports as resolved

**Admin**
- Admin dashboard
- Manage all reports
- Manage users (block / unblock accounts)

**Built with Laravel features**
- MVC structure with controllers, Eloquent models (`User`, `Report`, `VerificationAnswer`) and Blade views
- Database migrations for all tables
- Route grouping with `auth` middleware
- Server-side validation (for example photo type and 2 MB size limit)
- File uploads using the `public` storage disk

## Tech Stack

| Layer | Technology |
|-------|------------|
| Backend | PHP 8.2+, Laravel 12 |
| Database | MySQL (SQLite also works) |
| Frontend | Blade templates, CSS, Vite |
| Package managers | Composer, npm |

## Installation

Requirements: PHP 8.2+, Composer, Node.js, MySQL (for example via XAMPP).

```bash
# 1. Clone the repository
git clone https://github.com/eltlhibn/lost-and-found-laravel.git
cd lost-and-found-laravel

# 2. Install dependencies
composer install
npm install

# 3. Create your environment file and app key
cp .env.example .env
php artisan key:generate
```

4. Create an empty database named `lostandfound_db` in phpMyAdmin (or change `DB_DATABASE` in `.env`). Adjust `DB_USERNAME` and `DB_PASSWORD` in `.env` if needed.

```bash
# 5. Create tables and link the storage folder for photo uploads
php artisan migrate
php artisan storage:link

# 6. Run the app (two terminals)
php artisan serve
npm run dev
```

Open `http://127.0.0.1:8000/register` and create an account.

> Prefer SQLite? Set `DB_CONNECTION=sqlite` in `.env`, remove the other `DB_*` lines, and `php artisan migrate` will create the database file for you.

### Creating an admin account

Register normally, then run:

```bash
php artisan tinker
>>> App\Models\User::where('username', 'your_username')->update(['role' => 'admin']);
```

## Main Routes

| Route | Purpose |
|-------|---------|
| `/login`, `/register` | Authentication |
| `/dashboard` | Browse reports |
| `/reports/create` | Post a lost or found item |
| `/my-reports` | Manage your own reports |
| `/reports/{id}/answer` | Answer the verification question |
| `/admin/dashboard`, `/admin/reports`, `/admin/users` | Admin area |

## Author

**eltlhibn**: [github.com/eltlhibn](https://github.com/eltlhibn)
