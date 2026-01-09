# 7 Ensemble - Complete Setup Guide

## 📋 Table of Contents
1. [Prerequisites](#prerequisites)
2. [Installation Steps](#installation-steps)
3. [Configuration](#configuration)
4. [Database Setup](#database-setup)
5. [Running the Application](#running-the-application)
6. [Testing](#testing)
7. [Troubleshooting](#troubleshooting)

---

## ✅ Prerequisites

Before starting, ensure you have the following installed:

### Required Software
- **PHP 8.2 or higher**
- **Composer 2.x**
- **Node.js 18.x or higher**
- **NPM 9.x or higher**
- **MySQL 8.0 or PostgreSQL 15**
- **Git**

### Verify Installation
```bash
php -v          # Should show PHP 8.2+
composer -V     # Should show Composer 2.x
node -v         # Should show v18.x+
npm -v          # Should show 9.x+
mysql --version # Should show MySQL 8.0+
```

---

## 🚀 Installation Steps

### Step 1: Clone or Create Laravel 11 Project

#### Option A: Fresh Laravel Installation
```bash
composer create-project laravel/laravel 7ensemble-app
cd 7ensemble-app
```

#### Option B: Using Existing Repository
```bash
git clone https://github.com/yourusername/7ensemble-webportal.git
cd 7ensemble-webportal
```

---

### Step 2: Install PHP Dependencies
```bash
composer install
```

**Expected packages:**
- Laravel Framework 11.x
- Laravel Breeze (Authentication)
- Filament 3.x (Admin Panel)
- Stripe PHP SDK
- PayPal SDK
- DomPDF (PDF generation)
- Laravel Excel (Export)
- And more... (see composer.json)

---

### Step 3: Install JavaScript Dependencies
```bash
npm install
```

**Expected packages:**
- Tailwind CSS
- Alpine.js
- Chart.js
- Vite
- And more... (see package.json)

---

### Step 4: Environment Configuration

#### Copy Environment File
```bash
cp .env.example .env
```

#### Generate Application Key
```bash
php artisan key:generate
```

#### Edit `.env` File
Open `.env` and configure:

```env
# Application
APP_NAME="7 Ensemble"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
APP_LOCALE=fr
APP_TIMEZONE=Europe/Zurich

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=7ensemble_db
DB_USERNAME=root
DB_PASSWORD=your_password_here

# Mail (Use Mailtrap for testing)
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_FROM_ADDRESS="noreply@7ensemble.ch"
```

---

## 🗄️ Database Setup

### Step 1: Create Database
```bash
# MySQL
mysql -u root -p
CREATE DATABASE 7ensemble_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

### Step 2: Run Migrations
```bash
php artisan migrate
```

This will create tables:
- users
- constellations
- constellation_members
- tours
- transactions
- payment_methods
- referrals
- And more...

### Step 3: Seed Database (Optional - for testing)
```bash
php artisan db:seed
```

This creates:
- Test users
- Sample constellations
- Fake transactions
- Demo data

---

## 🎨 Install Laravel Breeze (Authentication)

### Step 1: Install Breeze
```bash
composer require laravel/breeze --dev
```

### Step 2: Install Breeze Scaffolding
```bash
php artisan breeze:install blade
```

When prompted, choose:
- **Stack:** Blade with Alpine
- **Dark mode:** No
- **Testing:** PHPUnit

### Step 3: Compile Assets
```bash
npm run dev
```

---

## 👨‍💼 Install Filament (Admin Panel)

### Step 1: Install Filament
```bash
composer require filament/filament:"^3.2" -W
```

### Step 2: Install Filament Panel
```bash
php artisan filament:install --panels
```

### Step 3: Create Admin User
```bash
php artisan make:filament-user
```

Enter:
- **Name:** Admin
- **Email:** admin@7ensemble.ch
- **Password:** (choose a strong password)

### Step 4: Access Admin Panel
```
http://localhost:8000/admin
```

---

## 📁 File Structure Setup

### Step 1: Create Directory Structure
```bash
# Create all necessary directories
mkdir -p app/Services
mkdir -p app/Helpers
mkdir -p app/Exports
mkdir -p app/Notifications
mkdir -p app/Events
mkdir -p app/Listeners
mkdir -p app/Jobs
mkdir -p app/Filament/Resources
mkdir -p app/Filament/Widgets
mkdir -p resources/views/pages
mkdir -p resources/views/dashboard
mkdir -p resources/views/auth
mkdir -p resources/views/emails
mkdir -p public/images
mkdir -p public/css
mkdir -p public/js
```

### Step 2: Copy Custom Files
Place the files from Phase 1 into their respective directories:

```
.env.example → .env (and configure)
config/7ensemble.php → config/
config/payment.php → config/
routes/web.php → routes/
routes/dashboard.php → routes/
routes/admin.php → routes/
resources/views/layouts/ → (all layouts)
resources/views/components/ → (all components)
app/Http/Middleware/ → (all middleware)
app/Providers/ConstellationServiceProvider.php → app/Providers/
```

---

## 🔧 Configuration

### Step 1: Register Service Provider
Edit `bootstrap/providers.php` and add:

```php
return [
    App\Providers\AppServiceProvider::class,
    App\Providers\ConstellationServiceProvider::class, // Add this
];
```

### Step 2: Register Middleware
Edit `bootstrap/app.php`:

```php
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CheckUserTour;
use App\Http\Middleware\EnsureUserHasConstellation;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->group(base_path('routes/dashboard.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'check.tour' => CheckUserTour::class,
            'has.constellation' => EnsureUserHasConstellation::class,
        ]);
    })
    ->create();
```

### Step 3: Publish Config Files
```bash
php artisan vendor:publish --tag=7ensemble-config
```

---

## 🎨 Frontend Setup

### Step 1: Create Tailwind Config
Create `tailwind.config.js`:

```javascript
/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./app/Filament/**/*.php",
  ],
  theme: {
    extend: {
      colors: {
        primary: '#667eea',
        secondary: '#764ba2',
        accent: '#4ecdc4',
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
  ],
}
```

### Step 2: Create Vite Config
Create `vite.config.js`:

```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/dashboard.css',
                'resources/js/app.js',
                'resources/js/dashboard.js',
            ],
            refresh: true,
        }),
    ],
});
```

### Step 3: Create CSS Files

**resources/css/app.css:**
```css
@tailwind base;
@tailwind components;
@tailwind utilities;

@layer components {
    .btn {
        @apply px-4 py-2 rounded-lg font-semibold transition-all;
    }
    .btn-primary {
        @apply bg-gradient-to-r from-purple-500 to-pink-500 text-white;
    }
}
```

**resources/css/dashboard.css:**
```css
/* Dashboard-specific styles */
.stat-card {
    @apply bg-white/10 backdrop-blur-lg rounded-lg p-6;
}
```

### Step 4: Create JS Files

**resources/js/app.js:**
```javascript
import './bootstrap';
import Alpine from 'alpinejs';
import confetti from 'canvas-confetti';

window.Alpine = Alpine;
window.confetti = confetti;

Alpine.start();
```

**resources/js/dashboard.js:**
```javascript
import Chart from 'chart.js/auto';

window.Chart = Chart;

// Dashboard-specific JavaScript
```

### Step 5: Build Assets
```bash
# Development (watch mode)
npm run dev

# Production build
npm run build
```

---

## ▶️ Running the Application

### Development Server
```bash
# Terminal 1: Run Laravel server
php artisan serve

# Terminal 2: Run Vite dev server
npm run dev
```

### Access the Application
- **Homepage:** http://localhost:8000
- **Dashboard:** http://localhost:8000/dashboard
- **Admin Panel:** http://localhost:8000/admin

---

## 🧪 Testing

### Run Tests
```bash
php artisan test
```

### Create Test User
```bash
php artisan tinker
```

```php
App\Models\User::factory()->create([
    'name' => 'Test User',
    'email' => 'test@7ensemble.ch',
    'password' => bcrypt('password123'),
]);
```

---

## 🔐 Payment Gateway Setup

### Stripe (Test Mode)
1. Create account at https://stripe.com
2. Get API keys from Dashboard > Developers > API keys
3. Add to `.env`:
```env
STRIPE_KEY=pk_test_...
STRIPE_SECRET=sk_test_...
```

### PayPal (Sandbox)
1. Create account at https://developer.paypal.com
2. Create sandbox app
3. Get credentials from Apps & Credentials
4. Add to `.env`:
```env
PAYPAL_MODE=sandbox
PAYPAL_SANDBOX_CLIENT_ID=...
PAYPAL_SANDBOX_CLIENT_SECRET=...
```

---

## 🐛 Troubleshooting

### Common Issues

#### 1. "Class not found" errors
```bash
composer dump-autoload
php artisan optimize:clear
```

#### 2. "Mix manifest not found"
```bash
npm run build
```

#### 3. Database connection errors
- Check MySQL is running
- Verify credentials in `.env`
- Ensure database exists

#### 4. Permission errors
```bash
chmod -R 775 storage bootstrap/cache
```

#### 5. Vite not working
```bash
npm install
npm run dev
```

---

## 📚 Next Steps

After successful installation:

1. ✅ Test authentication (register, login, logout)
2. ✅ Access admin panel at /admin
3. ✅ Configure payment gateways
4. ✅ Set up email (Mailtrap for testing)
5. ✅ Proceed to **Phase 2: Database Architecture**

---

## 🆘 Getting Help

- **Laravel Docs:** https://laravel.com/docs/11.x
- **Filament Docs:** https://filamentphp.com/docs
- **Issues:** Create an issue in the repository

---

## 📝 Notes

- Always use `.env` for sensitive data (never commit to Git)
- Test in development before deploying to production
- Keep dependencies updated monthly
- Backup database regularly

---

**Congratulations! Phase 1 is complete. You now have a fully functional Laravel 11 foundation! 🎉**

Proceed to **Phase 2: Database Architecture** when ready.
