<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeUpdate extends Model
{
    use HasFactory;
   public $timestamps = false;
   public $table = 'employeeupdates';

    protected $fillable = [
        'employeeId',
        'date',
        'starttime',
        'endtime',
        'update',
    ];
}
