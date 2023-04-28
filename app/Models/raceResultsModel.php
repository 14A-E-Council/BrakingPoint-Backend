<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class raceResultsModel extends Model
{
    use HasFactory;
    protected $table = 'raceResults';
    protected $primaryKey = 'raceResultsID';

    protected $fillable = [
        'raceName',
        'position',
        'points',
        'fastestLap',
        'time',
        'laps',
        'competitorID'
    ];
}
