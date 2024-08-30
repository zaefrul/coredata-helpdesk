<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'serial_number',
        'category',
        'project_id',
        'details',
        'purchased_date',
        'warranty_end',
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
