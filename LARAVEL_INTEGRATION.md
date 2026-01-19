# Laravel Backend Integration Guide

## 1. DATABASE MIGRATION

Create migration file: `database/migrations/2024_xx_xx_create_registrations_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('prenom');
            $table->string('nom');
            $table->string('email')->unique();
            $table->string('country');
            $table->string('payment_method');
            $table->enum('option', ['3', '7']);
            $table->boolean('terms_accepted')->default(true);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();

            $table->index('email');
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
```

Run migration:
```bash
php artisan migrate
```

## 2. MODEL

Create model: `app/Models/Registration.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'prenom',
        'nom',
        'email',
        'country',
        'payment_method',
        'option',
        'terms_accepted',
        'status',
    ];

    protected $casts = [
        'terms_accepted' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getFullNameAttribute(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }
}
```

## 3. FORM REQUEST VALIDATION

Create request: `app/Http/Requests/RegistrationRequest.php`

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'prenom' => ['required', 'string', 'min:2', 'max:100'],
            'nom' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:registrations,email'],
            'country' => ['required', 'string', 'max:50'],
            'paymentMethod' => ['required', 'string', 'in:card,paypal,transfer,mobile,crypto,other'],
            'choixOption' => ['required', 'in:3,7'],
            'terms' => ['accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'prenom.required' => 'Le prénom est requis.',
            'prenom.min' => 'Le prénom doit contenir au moins 2 caractères.',
            'nom.required' => 'Le nom est requis.',
            'nom.min' => 'Le nom doit contenir au moins 2 caractères.',
            'email.required' => 'L\'adresse email est requise.',
            'email.email' => 'L\'adresse email doit être valide.',
            'email.unique' => 'Cette adresse email est déjà enregistrée.',
            'country.required' => 'Le pays est requis.',
            'paymentMethod.required' => 'Le mode de paiement est requis.',
            'choixOption.required' => 'Vous devez choisir une option (3 ou 7 personnes).',
            'choixOption.in' => 'L\'option choisie n\'est pas valide.',
            'terms.accepted' => 'Vous devez accepter les conditions.',
        ];
    }
}
```

## 4. CONTROLLER

Create controller: `app/Http/Controllers/RegistrationController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\Registration;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationConfirmation;

class RegistrationController extends Controller
{
    public function store(RegistrationRequest $request): JsonResponse
    {
        try {
            // Create registration
            $registration = Registration::create([
                'prenom' => $request->input('prenom'),
                'nom' => $request->input('nom'),
                'email' => $request->input('email'),
                'country' => $request->input('country'),
                'payment_method' => $request->input('paymentMethod'),
                'option' => $request->input('choixOption'),
                'terms_accepted' => true,
                'status' => 'pending',
            ]);

            // Log successful registration
            Log::info('New registration created', [
                'id' => $registration->id,
                'email' => $registration->email,
                'option' => $registration->option,
            ]);

            // Send confirmation email (optional - uncomment if email is configured)
            // Mail::to($registration->email)->send(new RegistrationConfirmation($registration));

            return response()->json([
                'success' => true,
                'message' => 'Inscription réussie ! Nous vous contacterons bientôt pour finaliser votre participation.',
                'data' => [
                    'id' => $registration->id,
                    'prenom' => $registration->prenom,
                    'option' => $registration->option,
                ]
            ], 201);

        } catch (\Exception $e) {
            Log::error('Registration failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de l\'inscription. Veuillez réessayer.',
            ], 500);
        }
    }

    public function index(): JsonResponse
    {
        try {
            $registrations = Registration::latest()
                ->paginate(20);

            return response()->json([
                'success' => true,
                'data' => $registrations,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des inscriptions.',
            ], 500);
        }
    }
}
```

## 5. ROUTES

Add to `routes/api.php`:

```php
<?php

use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

// Public API routes
Route::post('/register', [RegistrationController::class, 'store']);

// Admin routes (protected by auth middleware)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/registrations', [RegistrationController::class, 'index']);
});
```

## 6. OPTIONAL: EMAIL NOTIFICATION

Create email: `app/Mail/RegistrationConfirmation.php`

```php
<?php

namespace App\Mail;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Registration $registration
    ) {}

    public function build()
    {
        return $this->subject('Bienvenue sur 7 Ensemble !')
            ->view('emails.registration-confirmation');
    }
}
```

Create view: `resources/views/emails/registration-confirmation.blade.php`

```html
<!DOCTYPE html>
<html>
<head>
    <title>Bienvenue sur 7 Ensemble</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px;">
        <h1 style="color: #4ecdc4;">🌟 Bienvenue {{ $registration->prenom }} !</h1>

        <p>Merci de vous être inscrit à <strong>7 Ensemble</strong>.</p>

        <div style="background: linear-gradient(45deg, rgba(78,205,196,0.1), rgba(102,126,234,0.1)); padding: 20px; border-radius: 8px; margin: 20px 0;">
            <h3>Récapitulatif de votre inscription :</h3>
            <ul style="list-style: none; padding: 0;">
                <li>👤 <strong>Nom complet :</strong> {{ $registration->prenom }} {{ $registration->nom }}</li>
                <li>📧 <strong>Email :</strong> {{ $registration->email }}</li>
                <li>🌍 <strong>Pays :</strong> {{ $registration->country }}</li>
                <li>✨ <strong>Option choisie :</strong> {{ $registration->option }} personnes</li>
            </ul>
        </div>

        <p>Notre équipe va examiner votre inscription et vous recontacter très bientôt.</p>

        <p style="margin-top: 30px; font-style: italic; color: #666;">
            "Ensemble, nous allons changer le monde !"
        </p>

        <hr style="margin: 30px 0; border: none; border-top: 1px solid #eee;">

        <p style="font-size: 0.9rem; color: #999;">
            Cet email a été envoyé automatiquement. Merci de ne pas répondre directement à ce message.
        </p>
    </div>
</body>
</html>
```

## 7. CORS CONFIGURATION (if frontend and backend are separate)

Update `config/cors.php`:

```php
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['*'], // In production, specify your frontend URL
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];
```

## 8. TESTING THE API

Test with cURL:

```bash
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "prenom": "Jean",
    "nom": "Dupont",
    "email": "jean.dupont@example.com",
    "country": "FR",
    "paymentMethod": "card",
    "choixOption": "7",
    "terms": "on"
  }'
```

## 9. DEPLOYMENT CHECKLIST

- [ ] Run migrations: `php artisan migrate`
- [ ] Configure `.env` file with database credentials
- [ ] Set up email configuration (if using notifications)
- [ ] Configure CORS for production
- [ ] Set up proper error logging
- [ ] Add rate limiting to prevent spam
- [ ] Test all form validations
- [ ] Test email confirmations
- [ ] Set up admin panel to view registrations

## 10. SECURITY RECOMMENDATIONS

1. Add CSRF protection (Laravel includes this by default)
2. Add rate limiting to the registration endpoint
3. Implement email verification if needed
4. Add reCAPTCHA to prevent bot submissions
5. Sanitize all inputs (Laravel does this automatically)
6. Use HTTPS in production
7. Implement proper logging and monitoring
