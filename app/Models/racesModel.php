<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class racesModel extends Model
{
    use HasFactory;
    protected $table = 'races';
    protected $primaryKey = 'raceID';
    public $timestamps = false;

    protected $fillable = [
        'circuitName',
        'circuitUrl',
        'country',
        'date'
        ];
}
