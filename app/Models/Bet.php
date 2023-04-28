<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bet extends Model
{
    protected $table = 'available_bets';
    public $timestamps = false;
    protected $fillable = [
        'title', //<-
        'date', 
        'category', 
        'odds', 
        'odds2',//<-
        'status', 
        'sportID'];
    protected $primaryKey = 'available_betID';
}
