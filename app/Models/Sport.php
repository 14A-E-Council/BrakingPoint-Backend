<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sport extends Model
{
    protected $table = 'sports';
    public $timestamps = false;
    protected $primaryKey = 'sportID';
    protected $fillable = [ 
        'name', 
        'description', 
    ];

    public function bets():HasMany{
        return $this->hasMany(Bet::class, 'sportID');
    }
    public function teams():HasMany{
        return $this->hasMany(Team::class, 'sportID');
    }
}
