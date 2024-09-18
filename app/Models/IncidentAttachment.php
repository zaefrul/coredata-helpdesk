<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'incident_id',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'file_extension',
    ];

    public function incident()
    {
        return $this->belongsTo(Incident::class);
    }
}
