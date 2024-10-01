<?php

namespace App\Models\front;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\admin\Level;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
        'password',
        'country',
        'trader_id',
        'referral_code',
        'referred_by',
        'level_id',
        'referred_by_level',
        'bonus_received'
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
        'password' => 'hashed',
    ];

    public function referrals()
    {
        return $this->hasMany(User::class,'referred_by');
    }

    public function level()
    {
        return $this->belongsTo(Level::class,'level_id');
    }
}
