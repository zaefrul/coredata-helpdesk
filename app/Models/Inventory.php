<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'model',
        'serial_number',
        'part_number',
        'item',
        'mfg_part_number',
        'type' //this will follow component_type
    ];
}
