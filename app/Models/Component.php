<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use HasFactory;

    protected $fillable = [
        'component_name',
        'serial_number',
        'part_number',
        'component_type',
        'component_model',
        'asset_id',
    ];
}
