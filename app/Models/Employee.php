<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use  HasFactory;

    protected $fillable = [
        'companyID',
        'userId',
        'firstname',
        'lastname',
        'email',
        'username',
        'address',
        'experience',
        'employeetype',
        'photo',
        'status',
        'password',
        'is_notice',
        'date',
    ];


}
