<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    protected $table = 'users';
    public $timestamps = false;
    protected $primaryKey = 'userID';
    protected $fillable = [
    'username', 
    'last_name',
    'first_name',
    'email',
    'password', 
    'balance', 
    'registration_date', 
    'prefered_category', 
    'level', 
    'picture_frame', 
    'rank', 
    'colour_palette', 
    'profile_picture'];
    protected $hidden = [
        'password',
    ];
    
    
    public function tickets(): HasMany{
        return $this->hasMany(Ticket::class, 'ticketID');
    }
}
