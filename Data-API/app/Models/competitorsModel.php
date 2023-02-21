<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class competitorsModel extends Model
{
    use HasFactory;
    protected $table = 'competitors';
    protected $primaryKey = 'competitorID';
    public $timestamps = true;

    protected $fillable = [
        'driverId',
        'permanentNumber',
        'code',
        'url',
        'givenName',
        'familyName',
        'dateOfBirth',
        'nationality',
        'name',
        'description',
        'teamID'
    ];
}
