<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solar extends Model
{
    protected $fillable = [
        'name',
        'mac',
        'voltage',
        'current',
        'power',
        'temperature',
    ];
}