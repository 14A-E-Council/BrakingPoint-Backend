<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';
    public $timestamps = false;
    protected $fillable = [
        'status', 
        'debt', 
        'sum_odds', 
        'races', 
        'payment_date', 
        'betID', // <-
        'userID'];

    protected $primaryKey = 'ticketID';
    
    public function bets():HasOne{
        return $this->hasOne(Bet::class, 'userID');
    }
    public function calculatePayout()
    {
        $this->payout = $this->odds * $this->betAmount;
        $this->save();
    }
}
