<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class raceResultsModel extends Model
{
    use HasFactory;
    protected $table = 'raceResults';
    protected $primaryKey = 'raceResultID';
    public $timestamps = false;

    protected $fillable = [
        'raceName',
        'name',
        'position',
        'points',
        'fastestLap',
        'laps',
        'date',
        'competitorID',
        'circuitID'
    ];
}
