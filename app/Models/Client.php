<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
     public $timestamps = false;
      public $table = 'clients';
      protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'country',
        'startdate',
        'enddate',
        'tecnology',
        'status',
        'companyID',
    ];
}
