<?php

namespace App\Models;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'city_id',
        'last_name',
        'first_name',
        'address',
        'phone_number',
        'email',
        'password',
        'is_active',
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
        'email_verified_at' => 'datetime',
    ];

    protected function password(): Attribute
    {
        return Attribute::make(set: fn($value) => Hash::make($value));
    }

    protected function lastName(): Attribute
    {
        return Attribute::make(set: fn($value) => ucfirst($value));
    }

    protected function firstName(): Attribute
    {
        return Attribute::make(set: fn($value) => ucfirst($value));
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(get: fn() => $this->last_name . ' ' . $this->first_name);
    }

    protected function fullAddress(): Attribute
    {
        return Attribute::make(get: fn() => $this->address . ', ' . $this->city->country->name . ', ' . $this->city->name);
    }

    public function scopeNotAdmin($query)
    {
        return $query->where('is_admin', '=', false);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['email'] ?? false, function ($query, $email) {
            $query->where('email', 'like', "%$email%");
        });

        $query->when($filters['last_name'] ?? false, function ($query, $last_name) {
            $query->where('last_name', 'like', "%$last_name%");
        });
        $query->when($filters['first_name'] ?? false, function ($query, $first_name) {
            $query->where('first_name', 'like', "%$first_name%");
        });
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'user_id');
    }
}
