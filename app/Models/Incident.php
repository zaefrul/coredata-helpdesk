<?php

namespace App\Models;

use App\Scopes\IncludeTrashedScope;
use App\Services\EmailService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Incident extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id', 
        'title', 
        'description',
        'status',
        'priority',
        'user_id',
        'customer_id',
        'asset_id',
        'site_location',
        'incident_type',
        'current_assignee_id',
        'incident_number',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class)->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class)->withTrashed();
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class)->withTrashed();
    }

    public function currentAssignee()
    {
        return $this->belongsTo(User::class, 'current_assignee_id')->withTrashed();
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function conversations()
    {
        return $this->hasMany(IncidentConversation::class);
    }

    public function attachments()
    {
        return $this->hasMany(IncidentAttachment::class);
    }

    // event
    public static function boot()
    {
        parent::boot();

        static::updated(function ($incident) {
            // Get the fields that have been changed
            $changes = $incident->getChanges();
    
            // Loop through each changed field and create a log entry
            foreach ($changes as $field => $newValue) {
                if ($field !== 'updated_at') { // Ignore the updated_at field
                    ActivityLog::create([
                        'incident_id' => $incident->id,
                        'user_id' => Auth::user()->id, // Assuming the user is authenticated
                        'description' => "Changed {$field} from '{$incident->getOriginal($field)}' to '{$newValue}'",
                    ]);
                }
            }

            // Send email notification
            $incident->user = User::find($incident->user_id);
            $departmentId = Contract::find($incident->contract_id)->department_id;
            $customer_notifications_email = CustomerNotification::where('department_id', $departmentId)->pluck('email')->toArray();
            $currentAssignee = User::find($incident->current_assignee_id);

            $recipients = array_merge($customer_notifications_email, [$incident->user->email], [$currentAssignee->email]);
            EmailService::sendIncidentNotification($incident, $recipients);
        });

        static::created(function ($incident) {
            ActivityLog::create([
                'incident_id' => $incident->id,
                'user_id' => $incident->user_id,
                'description' => "Created incident",
            ]);

            $incident->user = User::find($incident->user_id);
            $contract = Contract::find($incident->contract_id);
            $customer_notifications_email = CustomerNotification::where('department_id', $contract->department_id)->pluck('email')->toArray();
            $incidentUer = [$incident->user->email];
            $admins = User::where('role', 'admin')->pluck('email')->toArray();
            $recipients = array_merge($customer_notifications_email, $admins, $incidentUer);

            EmailService::sendIncidentNotification($incident, $recipients);
        });
    }
}
