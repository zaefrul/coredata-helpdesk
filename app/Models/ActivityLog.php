<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'incident_id', 'user_id', 'description', 'comment_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function incident()
    {
        return $this->belongsTo(Incident::class);
    }

    public function incidentConversation()
    {
        return $this->belongsTo(IncidentConversation::class);
    }
}
