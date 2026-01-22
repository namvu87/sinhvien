<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = [
        'name',
        'code',
        'type',
        'unit',
        'options',
        'is_active',
        'display_order',
    ];

    protected $casts = [
        'options' => 'array',
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];
}

