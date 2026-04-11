# TechMart

E-commerce storefront and admin panel built with **Laravel 12**, **Vite**, and **Tailwind CSS**. It includes product catalog, cart, checkout (cash on delivery and Stripe), wishlist, admin dashboard, and related tooling.

## Requirements

Before you start, install:

| Tool | Notes |
|------|--------|
| **PHP** | 8.2 or newer |
| **Composer** | 2.x |
| **Node.js** | 18+ or 20+ (LTS recommended) and npm |
| **MySQL** or **MariaDB** | A running server you can create a database on |

Recommended PHP extensions: `openssl`, `pdo`, `pdo_mysql`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`, `gd` (used for image handling).

## Quick start (local)

### 1. Clone the repository

```bash
git clone <your-repo-url> techmart
cd techmart
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Environment file

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` and set at least:

- `APP_URL` — e.g. `http://127.0.0.1:8000` (must match how you open the app in the browser if you use Vite dev server)
- `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` — your MySQL database and credentials

Create the empty database in MySQL (example):

```sql
CREATE DATABASE techmart CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

The sample `.env` expects `DB_CONNECTION=mysql` and database name `techmart`; adjust if you use something else.

### 4. Database migrations and optional seed

```bash
php artisan migrate
```

Optional — creates a default admin user, site settings, and SEO settings:

```bash
php artisan db:seed
```

After seeding, you can sign in to the admin area with:

- **Email:** `admin@gmail.com`  
- **Password:** `password`  

Change this password immediately in any shared or production environment.

### 5. Storage link (uploads / public files)

```bash
php artisan storage:link
```

### 6. Front-end assets

```bash
npm install
npm run build
```

For development with hot reload, use `npm run dev` in a separate terminal (see below).

### 7. Run the application

```bash
php artisan serve
```

Open [http://127.0.0.1:8000](http://127.0.0.1:8000) in your browser.

**Admin panel:** [http://127.0.0.1:8000/admin](http://127.0.0.1:8000/admin)

### Development mode (Vite + Laravel)

In one terminal:

```bash
php artisan serve
```

In another:

```bash
npm run dev
```

Set `APP_URL` in `.env` to the same host and port as `php artisan serve` so asset URLs stay correct.

## Composer shortcut

This project includes a Composer script that installs dependencies, ensures `.env` exists, generates the app key, runs migrations, installs npm packages, and builds front-end assets:

```bash
composer run setup
```

You still need to create the MySQL database and configure database credentials in `.env` before this succeeds. It does **not** run `db:seed` by default.

## Optional configuration

### Stripe (card payments)

Checkout supports **COD** without keys. For Stripe, add to `.env`:

```env
STRIPE_KEY=pk_test_...
STRIPE_SECRET=sk_test_...
```

### Google sign-in (Socialite)

If you use Google OAuth, set in `.env`:

```env
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_CALLBACK_REDIRECTS=
```

Configure the redirect URI in the Google Cloud console to match your `APP_URL` and routes.

### Search (Laravel Scout)

Scout defaults to the `collection` driver, which works locally without a separate search server. To use **Meilisearch**, install and run Meilisearch, then set `SCOUT_DRIVER=meilisearch` and the Meilisearch host/key as required by your `config/scout.php` / `.env` (see Laravel Scout documentation).

### Queue and mail

`.env.example` uses `QUEUE_CONNECTION=database` and `MAIL_MAILER=log`. For real order emails in production, configure mail (SMTP, etc.) and run a queue worker, for example:

```bash
php artisan queue:work
```

## Tests

```bash
composer test
```

or:

```bash
php artisan test
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
