<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'brand',
        'serial_number',
        'category',
        'contract_id',
        'details',
        'purchased_date',
        'warranty_end',
        'warranty_level',
        'location'
    ];

    // cast
    protected $casts = [
        'purchased_date' => 'date',
        'warranty_end' => 'date',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function components()
    {
        return $this->hasMany(Component::class);
    }
}
