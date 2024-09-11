<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class IncidentConversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'incident_id', 'user_id', 'message'
    ];

    public function incident()
    {
        return $this->belongsTo(Incident::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public static function boot() {
        parent::boot();

        static::saved(function($conversation) {
            Log::info(print_r($conversation, true));
            $acl = ActivityLog::create([
                'incident_id' => $conversation->incident_id,
                'user_id' => $conversation->user_id,
                'comment_id' => $conversation->id,
                'description' => 'Comment added'
            ]);
        });
    }
}
