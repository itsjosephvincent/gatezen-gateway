<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Services\PdfService;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Auditable as AuditTraits;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Tags\HasTags;

class User extends Authenticatable implements Auditable, FilamentUser
{
    use AuditTraits, HasApiTokens, HasFactory, HasRoles, HasTags, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'mobile',
        'email',
        'secondary_email',
        'third_email',
        'password',
        'is_blocked',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_blocked' => 'boolean',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected static function booted(): void
    {
        static::saving(function ($user): void {
            $user->firstname = Str::title($user->firstname);
            $user->middlename = Str::title($user->middlename);
            $user->lastname = Str::title($user->lastname);
            $user->email = Str::lower($user->email);

            if ($user->isDirty('password')) {
                $user->password_changed_at = now();
            }
        });
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole(['Super Admin', 'Admin', 'Manager', 'Accountant']);
    }

    public function getNameAttribute()
    {
        return implode(' ', array_filter([$this->firstname, $this->middlename, $this->lastname]));
    }

    public function entity(): HasOne
    {
        return $this->hasOne(Entity::class);
    }

    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function wallets(): MorphMany
    {
        return $this->morphMany(Wallet::class, 'holdable');
    }

    public function hasWallet($slug)
    {
        return $this->wallets()->where('slug', $slug);
    }

    /**
     * A User has many externable data
     */
    public function external()
    {
        return $this->morphMany(ExternalData::class, 'externable');
    }

    public function user_metas(): HasMany
    {
        return $this->hasMany(UserMeta::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function segment_users(): HasMany
    {
        return $this->hasMany(SegmentUser::class);
    }

    public function downloadPortfolio()
    {
        $pdfService = new PdfService();
        $pdfContent = $pdfService->downloadPortfolio($this);

        return $pdfContent;
    }

    public function customer_orders(): HasMany
    {
        return $this->hasMany(SalesOrder::class, 'customer_id');
    }

    public function deal_entries(): HasMany
    {
        return $this->hasMany(DealEntry::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'customer_id');
    }

    public function kyc_application(): HasOne
    {
        return $this->hasOne(KycApplication::class);
    }

    public function audits(): MorphMany
    {
        return $this->morphMany(Audit::class, 'auditable');
    }
}
