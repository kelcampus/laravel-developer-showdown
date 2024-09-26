<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserUpdate extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'firstname',
        'lastname',
        'time_zone',
    ];
}
