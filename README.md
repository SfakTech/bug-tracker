# Bug Tracker

Bug tracking app I built with PHP and MySQL. Started as a flat PHP project, refactored to MVC.

## Stack
- PHP 8.2
- MySQL
- HTML / CSS / JavaScript

## Running locally

### With ddev

```bash
git clone https://github.com/SfakTech/bug-tracker.git
cd bug-tracker
ddev start
ddev mysql < sql/users.sql
ddev mysql < sql/tickets.sql
ddev launch
```

### With MAMP

1. Clone inside `htdocs`
2. Create a database named `users_db` in phpMyAdmin and import `sql/users.sql` + `sql/tickets.sql`
3. Check credentials in `app/Core/DB.php` (default: host `localhost`, port `8889`, user/pass `root`)
4. Open `http://localhost:8888/bug-tracker/public/`

## Test accounts

| Role  | Email              | Password |
|-------|--------------------|----------|
| Admin | admin@sfaktech.com | admin123 |
| User  | user@sfaktech.com  | user123  |

---

## Structure

```
bug-tracker/
├── app/
│   ├── Controllers/
│   ├── Core/
│   ├── Middleware/
│   ├── Models/
│   └── Views/
├── config/
├── public/
│   ├── assets/
│   └── index.php
└── sql/
```

## License
MIT
