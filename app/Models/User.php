<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'password',
        'level_id',
        'points',
        'coins',
        'gems',
        'hearts',
        'profile_image'
    ];

    protected $with = ['chosenImage', 'level'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'is_admin'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    // Chosen profile image
    public function chosenImage(): BelongsTo
    {
        return $this->belongsTo(ProfileImage::class, 'profile_image');
    }

    // Owner
    public function profileImages(): HasMany
    {
        return $this->hasMany(ProfileImage::class);
    }
}
