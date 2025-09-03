# CI4 Auth + Teachers API

## Setup
1) Install PHP 8.1+, Composer, and MySQL.
2) `composer install`
3) Copy `.env.example` to `.env` and set DB + JWT values.
4) Import `sql/schema.mysql.sql` (and optional `sql/seed.mysql.sql`).
5) Run: `php spark key:generate` then `php spark serve`

## Endpoints
- `POST /api/auth/register`
- `POST /api/auth/login`
- `POST /api/teacher` (Bearer token required) – single POST that inserts into auth_user + teachers (transaction)
- `GET /api/users` (Bearer)
- `GET /api/teachers` (Bearer)
- `GET /api/teachers/join` (Bearer)
