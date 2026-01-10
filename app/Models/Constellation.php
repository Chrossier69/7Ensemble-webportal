<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Constellation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',
        'name',
        'code',
        'alcyone_id',
        'current_tour',
        'max_members',
        'current_members',
        'status',
        'total_collected',
        'total_distributed',
        'pending_amount',
        'formed_at',
        'completed_at',
        'last_tour_at',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'max_members' => 'integer',
            'current_members' => 'integer',
            'current_tour' => 'integer',
            'total_collected' => 'decimal:2',
            'total_distributed' => 'decimal:2',
            'pending_amount' => 'decimal:2',
            'formed_at' => 'datetime',
            'completed_at' => 'datetime',
            'last_tour_at' => 'datetime',
            'metadata' => 'array',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * Get the Alcyone (center person) of this constellation.
     */
    public function alcyone()
    {
        return $this->belongsTo(User::class, 'alcyone_id');
    }

    /**
     * Get all members of this constellation.
     */
    public function members()
    {
        return $this->hasMany(ConstellationMember::class);
    }

    /**
     * Get active members.
     */
    public function activeMembers()
    {
        return $this->hasMany(ConstellationMember::class)->where('status', 'active');
    }

    /**
     * Get all users in this constellation.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'constellation_members')
                    ->withPivot('position', 'status', 'is_alcyone')
                    ->withTimestamps();
    }

    /**
     * Get all tours for this constellation.
     */
    public function tours()
    {
        return $this->hasMany(Tour::class);
    }

    /**
     * Get all transactions for this constellation.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS & MUTATORS
    |--------------------------------------------------------------------------
    */

    /**
     * Get the constellation type label.
     */
    public function getTypeLabelAttribute(): string
    {
        return $this->type === 'triangulum' ? 'Triangulum (3)' : 'Les Pléiades (7)';
    }

    /**
     * Get the status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'forming' => 'En formation',
            'active' => 'Active',
            'completed' => 'Terminée',
            'disbanded' => 'Dissoute',
            'frozen' => 'Gelée',
            default => $this->status,
        };
    }

    /**
     * Check if constellation is full.
     */
    public function getIsFullAttribute(): bool
    {
        return $this->current_members >= $this->max_members;
    }

    /**
     * Get completion percentage.
     */
    public function getCompletionPercentageAttribute(): float
    {
        if ($this->max_members == 0) return 0;
        return ($this->current_members / $this->max_members) * 100;
    }

    /*
    |--------------------------------------------------------------------------
    | QUERY SCOPES
    |--------------------------------------------------------------------------
    */

    /**
     * Scope a query to only include active constellations.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include forming constellations.
     */
    public function scopeForming($query)
    {
        return $query->where('status', 'forming');
    }

    /**
     * Scope a query to only include Triangulum type.
     */
    public function scopeTriangulum($query)
    {
        return $query->where('type', 'triangulum');
    }

    /**
     * Scope a query to only include Pléiades type.
     */
    public function scopePleiades($query)
    {
        return $query->where('type', 'pleiades');
    }

    /**
     * Scope a query for available constellations (forming and not full).
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'forming')
                    ->whereRaw('current_members < max_members');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER METHODS
    |--------------------------------------------------------------------------
    */

    /**
     * Check if constellation is full.
     */
    public function isFull(): bool
    {
        return $this->current_members >= $this->max_members;
    }

    /**
     * Check if constellation is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Get available slots.
     */
    public function availableSlots(): int
    {
        return max(0, $this->max_members - $this->current_members);
    }

    /**
     * Assign a user to this constellation.
     */
    public function assignUser(User $user, int $position): ConstellationMember
    {
        $member = $this->members()->create([
            'user_id' => $user->id,
            'position' => $position,
            'status' => 'active',
            'joined_at' => now(),
        ]);

        $this->increment('current_members');

        // Update user's constellation
        $user->update([
            'constellation_id' => $this->id,
            'constellation_type' => $this->type,
        ]);

        // If constellation is full, activate it
        if ($this->isFull() && $this->status === 'forming') {
            $this->activate();
        }

        return $member;
    }

    /**
     * Activate constellation (when full).
     */
    public function activate(): bool
    {
        return $this->update([
            'status' => 'active',
            'formed_at' => now(),
        ]);
    }

    /**
     * Mark constellation as completed.
     */
    public function markCompleted(): bool
    {
        return $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }

    /**
     * Generate unique constellation code.
     */
    public static function generateCode(): string
    {
        do {
            $code = 'CONST-' . date('Y') . '-' . strtoupper(Str::random(6));
        } while (static::where('code', $code)->exists());

        return $code;
    }

    /*
    |--------------------------------------------------------------------------
    | MODEL EVENTS
    |--------------------------------------------------------------------------
    */

    protected static function boot()
    {
        parent::boot();

        // Generate code and set max_members on creation
        static::creating(function ($constellation) {
            if (empty($constellation->code)) {
                $constellation->code = static::generateCode();
            }

            if (empty($constellation->max_members)) {
                $constellation->max_members = $constellation->type === 'triangulum' ? 3 : 7;
            }
        });
    }
}
