# 7 Ensemble - Dependencies Documentation

## Overview
This document lists all PHP and JavaScript dependencies required for the 7 Ensemble web portal.

---

## PHP Dependencies (Composer)

### Core Framework
- **laravel/framework** (^11.0) - Laravel framework
- **guzzlehttp/guzzle** (^7.8) - HTTP client for API calls
- **laravel/tinker** (^2.9) - Interactive shell

### Authentication & Authorization
- **laravel/breeze** (^2.0) - Simple authentication scaffolding
- **spatie/laravel-permission** (^6.3) - Role and permission management

### Admin Panel
- **filament/filament** (^3.2) - Modern admin panel framework
  - Includes: Forms, Tables, Notifications, Widgets

### Payment Gateways
- **stripe/stripe-php** (^13.0) - Stripe payment integration
- **srmklive/paypal** (^3.0) - PayPal payment integration

### File Generation & Export
- **barryvdh/laravel-dompdf** (^2.2) - PDF generation
- **maatwebsite/excel** (^3.1) - Excel/CSV export and import

### Image Processing
- **intervention/image** (^3.5) - Image manipulation and upload handling

### Activity Logging
- **spatie/laravel-activitylog** (^4.8) - Log user activities and changes

### Real-time Features
- **pusher/pusher-php-server** (^7.2) - WebSocket for real-time notifications

### Development Dependencies
- **fakerphp/faker** (^1.23) - Generate fake data for testing
- **laravel/pint** (^1.13) - Laravel code style fixer
- **laravel/sail** (^1.26) - Docker development environment
- **mockery/mockery** (^1.6) - Mocking framework for tests
- **nunomaduro/collision** (^8.0) - Beautiful error reporting
- **phpunit/phpunit** (^11.0) - Testing framework
- **spatie/laravel-ignition** (^2.4) - Error page for Laravel

---

## JavaScript Dependencies (NPM)

### Build Tools
- **vite** (^5.0.11) - Fast build tool
- **laravel-vite-plugin** (^1.0.0) - Laravel integration for Vite
- **postcss** (^8.4.33) - CSS processor
- **autoprefixer** (^10.4.16) - Auto-add CSS vendor prefixes

### CSS Framework
- **tailwindcss** (^3.4.1) - Utility-first CSS framework
- **@tailwindcss/forms** (^0.5.7) - Form styles plugin
- **@tailwindcss/typography** (^0.5.10) - Typography plugin

### JavaScript Framework
- **alpinejs** (^3.13.3) - Lightweight reactive framework

### Charts & Visualization
- **chart.js** (^4.4.1) - Beautiful charts and graphs

### UI Components & Effects
- **canvas-confetti** (^1.9.2) - Confetti animations
- **sweetalert2** (^11.10.3) - Beautiful modal alerts
- **aos** (^3.0.0-beta.6) - Animate on scroll library
- **@splidejs/splide** (^4.1.4) - Carousel/slider component

### HTTP Client
- **axios** (^1.6.4) - Promise-based HTTP client

### Code Quality Tools
- **eslint** (^8.56.0) - JavaScript linter
- **prettier** (^3.1.1) - Code formatter

---

## Installation Commands

### Install PHP Dependencies
```bash
composer install
```

### Install JavaScript Dependencies
```bash
npm install
```

### Update Dependencies
```bash
# Update PHP dependencies
composer update

# Update JavaScript dependencies
npm update
```

---

## Package Purposes

### Why Each Package?

**Laravel Breeze** - Provides simple authentication scaffolding with login, registration, and password reset functionality.

**Filament** - Complete admin panel with CRUD operations, widgets, and beautiful UI without writing HTML.

**Stripe & PayPal** - Payment gateway integrations for accepting card payments and PayPal.

**DomPDF** - Generate PDF receipts, invoices, and reports for users.

**Laravel Excel** - Export transaction history, user data, and reports to Excel/CSV.

**Intervention Image** - Handle user avatar uploads, resize and optimize images.

**Spatie Permission** - Manage admin roles and user permissions (admin, user, moderator).

**Spatie Activity Log** - Track all user actions for security and audit purposes.

**Pusher** - Real-time notifications when payments are received or constellations are filled.

**AlpineJS** - Add interactivity to Blade templates without Vue/React complexity.

**Chart.js** - Display earnings charts, tour progress graphs, and admin analytics.

**Canvas Confetti** - Celebrate when users complete tours or receive payments.

**SweetAlert2** - Beautiful confirmation dialogs and success messages.

**AOS** - Smooth scroll animations on the homepage and marketing pages.

**Tailwind CSS** - Utility-first CSS framework for rapid UI development.

---

## Optional Packages (Future Enhancement)

Consider adding these packages in later phases:

```bash
# Two-Factor Authentication
composer require pragmarx/google2fa-laravel

# API Development
composer require laravel/sanctum

# Queue Management UI
composer require laravel/horizon

# Database Backup
composer require spatie/laravel-backup

# SEO Optimization
composer require artesaos/seotools

# Sitemap Generation
composer require spatie/laravel-sitemap
```

---

## Development vs Production

### Development Only
- laravel/sail (Docker)
- phpunit/phpunit (Testing)
- faker (Fake data)
- eslint, prettier (Code quality)

### Production Required
- All other packages are needed in production

---

## Keeping Dependencies Updated

Run these commands monthly:

```bash
# Check for outdated packages
composer outdated
npm outdated

# Update safely (respects version constraints)
composer update
npm update

# Check for security vulnerabilities
composer audit
npm audit
```

---

## License Notes

- Most packages are **MIT licensed** (free for commercial use)
- Stripe & PayPal SDKs are free but require API keys
- Filament is free for unlimited projects
- All packages are compatible with proprietary/commercial projects

---

## Support & Documentation

- Laravel: https://laravel.com/docs/11.x
- Filament: https://filamentphp.com/docs
- Tailwind CSS: https://tailwindcss.com/docs
- Stripe: https://stripe.com/docs/api
- PayPal: https://developer.paypal.com/docs/api
- Chart.js: https://www.chartjs.org/docs
- Alpine.js: https://alpinejs.dev/start-here
