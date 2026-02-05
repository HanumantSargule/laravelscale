<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const ROLE_CUSTOMER = 'customer';
    const ROLE_PROVIDER = 'provider';
    const ROLE_ADMIN    = 'admin';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationships

    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class);
    }

    public function enquiriesSent(): HasMany
    {
        return $this->hasMany(Enquiry::class, 'customer_id');
    }

    public function enquiriesReceived(): HasMany
    {
        return $this->hasMany(Enquiry::class, 'provider_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // Role helpers

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isProvider(): bool
    {
        return $this->role === self::ROLE_PROVIDER;
    }

    public function isCustomer(): bool
    {
        return $this->role === self::ROLE_CUSTOMER;
    }
}
