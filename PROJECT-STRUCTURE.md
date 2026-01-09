# 7 Ensemble - Complete Project Structure

## 📁 Directory Organization

```
7ensemble-webportal/
│
├── app/                                    # Application core
│   ├── Console/                            # Artisan commands
│   │   └── Commands/                       # Custom commands
│   │       ├── ProcessPendingPayments.php
│   │       ├── AssignUsersToConstellations.php
│   │       └── SendDailyReports.php
│   │
│   ├── Events/                             # Event classes
│   │   ├── ConstellationFilled.php
│   │   ├── TourCompleted.php
│   │   ├── PaymentReceived.php
│   │   └── UserRegistered.php
│   │
│   ├── Exceptions/                         # Exception handlers
│   │   ├── Handler.php
│   │   ├── PaymentException.php
│   │   └── ConstellationException.php
│   │
│   ├── Exports/                            # Export classes (Excel/CSV)
│   │   ├── TransactionsExport.php
│   │   ├── UsersExport.php
│   │   └── PaymentsExport.php
│   │
│   ├── Filament/                           # Filament admin panel
│   │   ├── Resources/                      # CRUD resources
│   │   │   ├── UserResource.php
│   │   │   ├── ConstellationResource.php
│   │   │   ├── TransactionResource.php
│   │   │   ├── TourResource.php
│   │   │   └── ReferralResource.php
│   │   │
│   │   ├── Widgets/                        # Dashboard widgets
│   │   │   ├── StatsOverviewWidget.php
│   │   │   ├── RevenueChartWidget.php
│   │   │   └── UserGrowthWidget.php
│   │   │
│   │   └── Pages/                          # Custom admin pages
│   │       └── AdminDashboard.php
│   │
│   ├── Helpers/                            # Helper functions
│   │   ├── TourHelper.php
│   │   ├── StatusHelper.php
│   │   └── CurrencyHelper.php
│   │
│   ├── Http/                               # HTTP layer
│   │   ├── Controllers/                    # Controllers
│   │   │   ├── HomeController.php
│   │   │   ├── TourController.php
│   │   │   ├── MissionController.php
│   │   │   ├── PaymentController.php
│   │   │   │
│   │   │   ├── Auth/                       # Authentication
│   │   │   │   ├── RegisterController.php
│   │   │   │   └── LoginController.php
│   │   │   │
│   │   │   └── Dashboard/                  # Dashboard controllers
│   │   │       ├── DashboardController.php
│   │   │       ├── ConstellationController.php
│   │   │       ├── TourController.php
│   │   │       ├── PaymentController.php
│   │   │       ├── TransferController.php
│   │   │       ├── ReferralController.php
│   │   │       ├── SettingsController.php
│   │   │       └── NotificationController.php
│   │   │
│   │   ├── Middleware/                     # Middleware
│   │   │   ├── CheckUserTour.php
│   │   │   ├── EnsureUserHasConstellation.php
│   │   │   ├── AdminMiddleware.php
│   │   │   └── VerifyEmailMiddleware.php
│   │   │
│   │   └── Requests/                       # Form requests
│   │       ├── RegisterRequest.php
│   │       ├── PaymentRequest.php
│   │       └── TransferRequest.php
│   │
│   ├── Jobs/                               # Queue jobs
│   │   ├── ProcessPaymentJob.php
│   │   ├── AssignToConstellation.php
│   │   ├── ProcessTourCompletion.php
│   │   ├── DistributePayouts.php
│   │   └── SendEmailJob.php
│   │
│   ├── Listeners/                          # Event listeners
│   │   ├── PromoteAlcyone.php
│   │   ├── NotifyMembers.php
│   │   ├── SendWelcomeEmail.php
│   │   └── LogUserActivity.php
│   │
│   ├── Mail/                               # Mail classes
│   │   ├── WelcomeEmail.php
│   │   ├── PaymentConfirmation.php
│   │   ├── TourCompleted.php
│   │   └── PayoutReceived.php
│   │
│   ├── Models/                             # Eloquent models
│   │   ├── User.php
│   │   ├── Constellation.php
│   │   ├── ConstellationMember.php
│   │   ├── Tour.php
│   │   ├── Transaction.php
│   │   ├── PaymentMethod.php
│   │   └── Referral.php
│   │
│   ├── Notifications/                      # Notification classes
│   │   ├── WelcomeNotification.php
│   │   ├── PaymentConfirmedNotification.php
│   │   ├── TourCompletedNotification.php
│   │   ├── PayoutReceivedNotification.php
│   │   └── ReferralBonusNotification.php
│   │
│   ├── Policies/                           # Authorization policies
│   │   ├── UserPolicy.php
│   │   ├── ConstellationPolicy.php
│   │   └── TransactionPolicy.php
│   │
│   ├── Providers/                          # Service providers
│   │   ├── AppServiceProvider.php
│   │   ├── ConstellationServiceProvider.php
│   │   ├── EventServiceProvider.php
│   │   └── RouteServiceProvider.php
│   │
│   └── Services/                           # Business logic services
│       ├── ConstellationService.php
│       ├── TourService.php
│       ├── PayoutService.php
│       ├── ReferralService.php
│       ├── ExportService.php
│       ├── ChartService.php
│       │
│       └── Payment/                        # Payment services
│           ├── PaymentGateway.php          # Interface
│           ├── StripeService.php
│           ├── PayPalService.php
│           ├── CryptoService.php
│           └── MobileMoneyService.php
│
├── bootstrap/                              # Bootstrap files
│   ├── app.php
│   ├── providers.php
│   └── cache/
│
├── config/                                 # Configuration files
│   ├── app.php
│   ├── database.php
│   ├── mail.php
│   ├── queue.php
│   ├── 7ensemble.php                       # ⭐ Custom config
│   ├── payment.php                         # ⭐ Payment config
│   └── filament.php
│
├── database/                               # Database files
│   ├── factories/                          # Model factories
│   │   ├── UserFactory.php
│   │   ├── ConstellationFactory.php
│   │   └── TransactionFactory.php
│   │
│   ├── migrations/                         # Database migrations
│   │   ├── 2024_01_01_000000_create_users_table.php
│   │   ├── 2024_01_02_000000_create_constellations_table.php
│   │   ├── 2024_01_03_000000_create_constellation_members_table.php
│   │   ├── 2024_01_04_000000_create_tours_table.php
│   │   ├── 2024_01_05_000000_create_transactions_table.php
│   │   ├── 2024_01_06_000000_create_payment_methods_table.php
│   │   └── 2024_01_07_000000_create_referrals_table.php
│   │
│   └── seeders/                            # Database seeders
│       ├── DatabaseSeeder.php
│       ├── UserSeeder.php
│       └── ConstellationSeeder.php
│
├── public/                                 # Public assets
│   ├── css/
│   │   ├── app.css
│   │   └── dashboard.css
│   ├── js/
│   │   ├── app.js
│   │   └── animations.js
│   ├── images/
│   │   ├── logo.png
│   │   ├── favicon.png
│   │   └── og-image.jpg
│   └── index.php                           # Entry point
│
├── resources/                              # Raw resources
│   ├── css/                                # Raw CSS
│   │   ├── app.css
│   │   └── dashboard.css
│   │
│   ├── js/                                 # Raw JavaScript
│   │   ├── app.js
│   │   └── dashboard.js
│   │
│   ├── lang/                               # Translations
│   │   ├── fr/
│   │   │   ├── auth.php
│   │   │   ├── validation.php
│   │   │   └── messages.php
│   │   └── en/
│   │
│   └── views/                              # Blade templates
│       ├── layouts/                        # ⭐ Layouts
│       │   ├── app.blade.php               # Public layout
│       │   └── dashboard.blade.php         # Dashboard layout
│       │
│       ├── components/                     # ⭐ Components
│       │   ├── header.blade.php
│       │   ├── footer.blade.php
│       │   ├── card.blade.php
│       │   └── modal.blade.php
│       │
│       ├── pages/                          # Public pages
│       │   ├── index.blade.php             # Homepage
│       │   ├── tours.blade.php             # Tours page
│       │   ├── mission.blade.php           # Mission page
│       │   ├── faq.blade.php
│       │   └── contact.blade.php
│       │
│       ├── auth/                           # Authentication views
│       │   ├── login.blade.php
│       │   ├── register.blade.php
│       │   ├── forgot-password.blade.php
│       │   └── verify-email.blade.php
│       │
│       ├── dashboard/                      # Dashboard views
│       │   ├── index.blade.php
│       │   ├── constellation.blade.php
│       │   ├── tours.blade.php
│       │   ├── payments.blade.php
│       │   ├── transfers.blade.php
│       │   ├── referrals.blade.php
│       │   └── settings.blade.php
│       │
│       ├── emails/                         # Email templates
│       │   ├── welcome.blade.php
│       │   ├── payment-confirmed.blade.php
│       │   ├── tour-completed.blade.php
│       │   └── payout-received.blade.php
│       │
│       └── errors/                         # Error pages
│           ├── 404.blade.php
│           ├── 403.blade.php
│           └── 500.blade.php
│
├── routes/                                 # Route files
│   ├── web.php                             # ⭐ Public routes
│   ├── dashboard.php                       # ⭐ Dashboard routes
│   ├── admin.php                           # ⭐ Admin routes (Filament)
│   ├── api.php                             # API routes
│   └── console.php                         # Artisan commands
│
├── storage/                                # Storage
│   ├── app/
│   │   ├── public/                         # Public storage (symlinked)
│   │   └── private/
│   ├── framework/
│   │   ├── cache/
│   │   ├── sessions/
│   │   └── views/
│   └── logs/
│
├── tests/                                  # Tests
│   ├── Feature/                            # Feature tests
│   │   ├── RegistrationTest.php
│   │   ├── PaymentTest.php
│   │   ├── ConstellationTest.php
│   │   └── TourTest.php
│   │
│   └── Unit/                               # Unit tests
│       ├── PayoutCalculationTest.php
│       └── ReferralBonusTest.php
│
├── .env.example                            # ⭐ Environment template
├── .gitignore
├── artisan                                 # Artisan CLI
├── composer.json                           # ⭐ PHP dependencies
├── package.json                            # ⭐ NPM dependencies
├── phpunit.xml                             # PHPUnit config
├── vite.config.js                          # Vite config
├── tailwind.config.js                      # Tailwind config
├── README.md                               # Project overview
├── README-SETUP.md                         # ⭐ Setup instructions
├── PROJECT-STRUCTURE.md                    # ⭐ This file
└── DEPENDENCIES.md                         # ⭐ Dependencies documentation
```

---

## 🗂️ File Purposes

### Core Application Files

**app/Models/** - Database models with relationships
- `User.php` - User model with constellation relationship
- `Constellation.php` - Constellation model (7 or 3 members)
- `Tour.php` - Tour progression tracking
- `Transaction.php` - Payment transactions

**app/Services/** - Business logic (reusable)
- `ConstellationService.php` - Manage constellation creation/assignment
- `TourService.php` - Handle tour progression logic
- `PayoutService.php` - Calculate and distribute payouts
- `Payment/StripeService.php` - Stripe integration

**app/Http/Controllers/** - Handle HTTP requests
- `HomeController.php` - Public pages (homepage, tours, mission)
- `Dashboard/DashboardController.php` - User dashboard
- `PaymentController.php` - Payment processing

**app/Http/Middleware/** - Request filtering
- `CheckUserTour.php` - Verify user has access to tour
- `EnsureUserHasConstellation.php` - Check constellation membership
- `AdminMiddleware.php` - Protect admin routes

---

## 🎨 Frontend Files

**resources/views/layouts/**
- `app.blade.php` - Main public layout (cosmic theme)
- `dashboard.blade.php` - Dashboard layout (sidebar + header)

**resources/views/components/**
- `header.blade.php` - Navigation bar
- `footer.blade.php` - Footer with links and language selector

**resources/css/**
- `app.css` - Tailwind base + public site styles
- `dashboard.css` - Dashboard-specific styles

**resources/js/**
- `app.js` - Alpine.js, confetti, global scripts
- `dashboard.js` - Chart.js, dashboard interactivity

---

## ⚙️ Configuration Files

**config/7ensemble.php** - Custom configuration
- Constellation types (Triangulum, Pléiades)
- Tour amounts and progression
- Payment settings
- Referral system

**config/payment.php** - Payment gateways
- Stripe configuration
- PayPal configuration
- Mobile Money settings
- Crypto settings

**.env** - Environment variables
- Database credentials
- Payment API keys
- Mail settings
- App configuration

---

## 📊 Database Files

**database/migrations/** - Database schema
- Users table (name, email, constellation_id, current_tour)
- Constellations table (type, status, alcyone_id)
- Transactions table (amount, type, status)
- Tours table (user_id, tour_number, completed_at)

**database/seeders/** - Test data
- Create sample users
- Generate fake constellations
- Seed transactions

---

## 🚦 Routes Organization

**routes/web.php** - Public routes
- `/` - Homepage
- `/tours` - Tours page
- `/mission` - Mission page
- `/login` - Login
- `/register` - Registration

**routes/dashboard.php** - Protected user routes
- `/dashboard` - Main dashboard
- `/dashboard/constellation` - My constellation
- `/dashboard/tours` - Tour progress
- `/dashboard/payments` - Payment history

**routes/admin.php** - Admin routes (Filament)
- `/admin` - Admin panel login
- Filament auto-generates CRUD routes

---

## 📦 Package Organization

### PHP Packages (composer.json)
- **laravel/framework** - Laravel core
- **laravel/breeze** - Authentication
- **filament/filament** - Admin panel
- **stripe/stripe-php** - Stripe payments
- **srmklive/paypal** - PayPal payments
- **barryvdh/laravel-dompdf** - PDF generation
- **maatwebsite/excel** - Excel exports

### JavaScript Packages (package.json)
- **tailwindcss** - CSS framework
- **alpinejs** - Reactive framework
- **chart.js** - Charts and graphs
- **canvas-confetti** - Celebrations
- **vite** - Build tool

---

## 🔄 Data Flow

### User Registration Flow
```
User → RegisterController → RegisterRequest (validation)
     → UserRegistrationService → Create User
     → Assign to Constellation (Job)
     → Send Welcome Email (Job)
     → Redirect to Dashboard
```

### Payment Flow
```
User → PaymentController → PaymentRequest (validation)
     → StripeService/PayPalService → Process Payment
     → Create Transaction Record
     → Update User Tour Progress
     → Distribute Payout to Alcyone
     → Send Confirmation Email
     → Update Dashboard
```

### Constellation Flow
```
User Registers → ConstellationService
              → Check Available Constellations
              → Assign to Constellation (or create new)
              → If Constellation Full → Mark as Active
              → Notify All Members
              → Start Tour 1
```

---

## 🎯 Key Features by Directory

### Authentication (`app/Http/Controllers/Auth/`)
- Login/Logout
- Registration with payment method selection
- Email verification
- Password reset

### Dashboard (`resources/views/dashboard/`)
- Overview stats (earnings, current tour)
- Constellation members list
- Tour progress timeline
- Payment history
- Transfer/withdraw money

### Admin Panel (`app/Filament/`)
- User management (CRUD)
- Constellation management
- Transaction monitoring
- Revenue charts
- System settings

### Email System (`app/Mail/`, `resources/views/emails/`)
- Welcome email (after registration)
- Payment confirmation
- Tour completion notification
- Payout received notification

---

## 📝 File Naming Conventions

**Controllers:** `PascalCaseController.php`
- Example: `ConstellationController.php`

**Models:** `PascalCase.php`
- Example: `ConstellationMember.php`

**Views:** `kebab-case.blade.php`
- Example: `payment-history.blade.php`

**Services:** `PascalCaseService.php`
- Example: `PayoutService.php`

**Middleware:** `PascalCaseMiddleware.php`
- Example: `CheckUserTour.php`

---

## 🚀 Next Steps

After understanding the structure:

1. Create all missing directories
2. Copy Phase 1 files to their locations
3. Register middleware and service providers
4. Create helper files
5. Proceed to **Phase 2: Database Architecture**

---

## 📚 Additional Resources

- **Laravel Structure:** https://laravel.com/docs/11.x/structure
- **Filament:** https://filamentphp.com/docs/3.x/panels/structure
- **Tailwind CSS:** https://tailwindcss.com/docs

---

**This structure follows Laravel 11 best practices and is optimized for the 7 Ensemble platform! 🚀**
