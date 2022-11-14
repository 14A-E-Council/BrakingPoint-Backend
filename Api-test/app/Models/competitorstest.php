<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 /* Az adatbázis tábla amihez illik:
 CREATE TABLE brakingpoint.competitorstest (
  ID int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  driverId varchar(255) NOT NULL,
  permanentNumber int(11) NOT NULL,
  code varchar(255) NOT NULL,
  url varchar(255) NOT NULL,
  givenName varchar(255) NOT NULL,
  familyName varchar(255) NOT NULL,
  dateOfBirth date NOT NULL,
  nationality varchar(255) DEFAULT NULL,
  PRIMARY KEY (ID)
)
ENGINE = INNODB,
CHARACTER SET utf8mb4,
COLLATE utf8mb4_hungarian_ci;
 */
class competitorstest extends Model
{
    use HasFactory;
    protected $table = 'competitorstest';
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
        'nationality'
    ];
}
