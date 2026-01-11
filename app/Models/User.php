<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'country',
        'avatar_url',
        'date_of_birth',
        'constellation_id',
        'current_tour',
        'constellation_type',
        'is_alcyone',
        'referral_code',
        'referred_by_id',
        'referral_earnings',
        'total_paid',
        'total_received',
        'total_earnings',
        'available_balance',
        'has_paid_initial',
        'initial_payment_at',
        'payment_verified',
        'status',
        'role',
        'preferences',
        'kyc_data',
        'two_factor_secret',
        'two_factor_enabled',
        'last_login_at',
        'last_login_ip',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
            'is_alcyone' => 'boolean',
            'has_paid_initial' => 'boolean',
            'initial_payment_at' => 'datetime',
            'payment_verified' => 'boolean',
            'two_factor_enabled' => 'boolean',
            'last_login_at' => 'datetime',
            'preferences' => 'array',
            'kyc_data' => 'array',
            'total_paid' => 'decimal:2',
            'total_received' => 'decimal:2',
            'total_earnings' => 'decimal:2',
            'available_balance' => 'decimal:2',
            'referral_earnings' => 'decimal:2',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * Get the constellation that the user belongs to.
     */
    public function constellation()
    {
        return $this->belongsTo(Constellation::class);
    }

    /**
     * Get the constellation membership details.
     */
    public function constellationMember()
    {
        return $this->hasOne(ConstellationMember::class);
    }

    /**
     * Get all tours for this user.
     */
    public function tours()
    {
        return $this->hasMany(Tour::class);
    }

    /**
     * Get the current tour for this user.
     */
    public function currentTourRecord()
    {
        return $this->hasOne(Tour::class)->where('tour_number', $this->current_tour);
    }

    /**
     * Get all transactions for this user.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get pending transactions.
     */
    public function pendingTransactions()
    {
        return $this->hasMany(Transaction::class)->where('status', 'pending');
    }

    /**
     * Get completed transactions.
     */
    public function completedTransactions()
    {
        return $this->hasMany(Transaction::class)->where('status', 'completed');
    }

    /**
     * Get all payouts for this user.
     */
    public function payouts()
    {
        return $this->hasMany(Payout::class);
    }

    /**
     * Get pending payouts.
     */
    public function pendingPayouts()
    {
        return $this->hasMany(Payout::class)->where('status', 'pending');
    }

    /**
     * Get payment methods for this user.
     */
    public function paymentMethods()
    {
        return $this->hasMany(PaymentMethod::class);
    }

    /**
     * Get the default payment method.
     */
    public function defaultPaymentMethod()
    {
        return $this->hasOne(PaymentMethod::class)->where('is_default', true);
    }

    /**
     * Get user settings.
     */
    public function settings()
    {
        return $this->hasOne(UserSetting::class);
    }

    /**
     * Get the user who referred this user.
     */
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by_id');
    }

    /**
     * Get all users referred by this user.
     */
    public function referrals()
    {
        return $this->hasMany(User::class, 'referred_by_id');
    }

    /**
     * Get referral records where this user is the referrer.
     */
    public function referralsSent()
    {
        return $this->hasMany(Referral::class, 'referrer_id');
    }

    /**
     * Get referral records where this user is the referee.
     */
    public function referralsReceived()
    {
        return $this->hasMany(Referral::class, 'referee_id');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS & MUTATORS
    |--------------------------------------------------------------------------
    */

    /**
     * Get the user's first name.
     */
    public function getFirstNameAttribute(): string
    {
        return explode(' ', $this->name)[0] ?? '';
    }

    /**
     * Get the user's initials.
     */
    public function getInitialsAttribute(): string
    {
        $parts = explode(' ', $this->name);
        $initials = '';
        foreach ($parts as $part) {
            $initials .= strtoupper(substr($part, 0, 1));
        }
        return $initials;
    }

    /**
     * Get the user's avatar or generate one.
     */
    public function getAvatarAttribute(): string
    {
        return $this->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=667eea&color=fff';
    }

    /*
    |--------------------------------------------------------------------------
    | QUERY SCOPES
    |--------------------------------------------------------------------------
    */

    /**
     * Scope a query to only include active users.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include users in a constellation.
     */
    public function scopeInConstellation($query)
    {
        return $query->whereNotNull('constellation_id');
    }

    /**
     * Scope a query to only include users who paid initial payment.
     */
    public function scopePaidInitial($query)
    {
        return $query->where('has_paid_initial', true);
    }

    /**
     * Scope a query to only include admin users.
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Scope a query to only include Alcyones.
     */
    public function scopeAlcyones($query)
    {
        return $query->where('is_alcyone', true);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER METHODS
    |--------------------------------------------------------------------------
    */

    /**
     * Check if user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is a moderator.
     */
    public function isModerator(): bool
    {
        return $this->role === 'moderator';
    }

    /**
     * Check if user is Alcyone.
     */
    public function isAlcyone(): bool
    {
        return $this->is_alcyone;
    }

    /**
     * Check if user has completed initial payment.
     */
    public function hasCompletedInitialPayment(): bool
    {
        return $this->has_paid_initial;
    }

    /**
     * Check if user has pending payments.
     */
    public function hasPendingPayments(): bool
    {
        return $this->pendingTransactions()->exists();
    }

    /**
     * Get total referral count.
     */
    public function getTotalReferralsAttribute(): int
    {
        return $this->referrals()->count();
    }

    /**
     * Get qualified referrals count.
     */
    public function getQualifiedReferralsAttribute(): int
    {
        return $this->referralsSent()->where('is_qualified', true)->count();
    }

    /**
     * Calculate net earnings.
     */
    public function calculateNetEarnings(): float
    {
        return $this->total_received - $this->total_paid;
    }

    /**
     * Generate unique referral code.
     */
    public static function generateReferralCode(): string
    {
        do {
            $code = '7E-' . strtoupper(Str::random(8));
        } while (static::where('referral_code', $code)->exists());

        return $code;
    }

    /*
    |--------------------------------------------------------------------------
    | MODEL EVENTS
    |--------------------------------------------------------------------------
    */

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Generate referral code on user creation
        static::creating(function ($user) {
            if (empty($user->referral_code)) {
                $user->referral_code = static::generateReferralCode();
            }
        });

        // Create user settings on user creation
        static::created(function ($user) {
            $user->settings()->create([]);
        });
    }
}
