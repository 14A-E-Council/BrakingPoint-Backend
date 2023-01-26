<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class competitorsModel extends Model
{
    use HasFactory;
    protected $table = 'competitors';
    protected $primaryKey = 'ID';
    public $timestamps = false;

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
        'description'
    ];
}
