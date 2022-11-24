<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'employeeId',
        'userId',
        'days',
        'fromdate',
        'todate',
        'status',
        'reason',
        
    ];
}
