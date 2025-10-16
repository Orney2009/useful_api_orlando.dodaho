<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_module extends Model
{
    protected $fillable = [
        'user_id',
        'module_id',
        'active',
    ];
}
