# TechMart

An e-commerce store with a customer-facing site and an admin panel. This project is built with **Laravel**, **Bootstrap**, and **JavaScript**. Front-end assets are compiled with **Vite** when you develop or build for production.

## What you need installed

- **PHP** 8.2 or newer  
- **Composer**  
- **Node.js** (LTS, e.g. 18 or 20) and **npm**  
- **MySQL** or **MariaDB**  

PHP should include common extensions such as `openssl`, `pdo_mysql`, `mbstring`, `json`, `fileinfo`, and `gd` (for images).

## Run the project on your computer

**1. Get the code**

```bash
git clone <your-repo-url> techmart
cd techmart
```

**2. Install PHP packages**

```bash
composer install
```

**3. Set up the environment**

```bash
cp .env.example .env
php artisan key:generate
```

Open `.env` and set your database details (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`) and `APP_URL` (for local use, `http://127.0.0.1:8000` is fine).

Create an empty database in MySQL, for example:

```sql
CREATE DATABASE techmart CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

**4. Create the database tables**

```bash
php artisan migrate
```

**5. (Optional) Sample admin and settings**

```bash
php artisan db:seed
```

After seeding, the admin login is **admin@gmail.com** / **password**. Change this password if the app is not only on your own machine.

**6. Public storage link**

```bash
php artisan storage:link
```

**7. Install and build front-end assets**

```bash
npm install
npm run build
```

**8. Start Laravel**

```bash
php artisan serve
```

Open **http://127.0.0.1:8000** in your browser. Admin area: **http://127.0.0.1:8000/admin**.

## Development mode (Vite + Laravel)

While you are changing CSS or JavaScript, run two terminals:

**Terminal 1 — Laravel**

```bash
php artisan serve
```

**Terminal 2 — Vite (live reload for assets)**

```bash
npm run dev
```

Keep `APP_URL` in `.env` the same as the address you use in the browser (for example `http://127.0.0.1:8000`).

## Optional: Stripe, Google login, email

- **Stripe** — Card checkout needs `STRIPE_KEY` and `STRIPE_SECRET` in `.env`. Cash on delivery works without them.  
- **Google sign-in** — Set `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, and `GOOGLE_CALLBACK_REDIRECTS` in `.env` if you use it.  
- **Email / queues** — For real emails (for example order notifications), configure mail in `.env` and run `php artisan queue:work` when using the database queue.

## License

This project is licensed under the [MIT license](https://opensource.org/licenses/MIT).
