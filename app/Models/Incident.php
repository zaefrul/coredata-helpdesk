<?php

namespace App\Models;

use App\Notifications\NewIncidentNotification;
use App\Scopes\IncludeTrashedScope;
use App\Services\EmailService;
use Carbon\Carbon;
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
        'start_date',
        'end_date',
    ];

    // cast attributes
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
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
                    if ($field === "start_date" || $field === "end_date") {
                        $newValueString = Carbon::parse($newValue)->format('d-M-Y');
                        $oldValueString = Carbon::parse($incident->getOriginal($field))->format('d-M-Y');

                        ActivityLog::create([
                            'incident_id' => $incident->id,
                            'user_id' => Auth::user()->id, // Assuming the user is authenticated
                            'description' => "Changed {$field} from '{$oldValueString}' to '{$newValueString}'",
                        ]);

                        continue;
                    }

                    ActivityLog::create([
                        'incident_id' => $incident->id,
                        'user_id' => Auth::user()->id, // Assuming the user is authenticated
                        'description' => "Changed {$field} from '{$incident->getOriginal($field)}' to '{$newValue}'",
                    ]);
                }

                // if incident is resolved
                if ($field === 'status' && $newValue === 'resolved') {
                    Incident::withoutEvents(function () use ($incident) {
                        $incident->resolved_at = now();
                        $incident->save();
                    });
                }

                
            }

            // Send email notification
            $incident->user = User::find($incident->user_id);
            $departmentId = Contract::find($incident->contract_id)->department_id;
            $customer_notifications_email = CustomerNotification::where('department_id', $departmentId)->pluck('email')->toArray();
            $currentAssignee = User::find($incident->current_assignee_id);

            $recipients = array_merge($customer_notifications_email, [$incident->user->email], [$currentAssignee->email]);
            EmailService::sendIncidentNotification($incident, $recipients, [], [], true);
        });

        static::created(function ($incident) {
            ActivityLog::create([
                'incident_id' => $incident->id,
                'user_id' => $incident->user_id,
                'description' => "Created incident",
            ]);

            // Send email notification

            $incident->user = User::find($incident->user_id);
            $contract = Contract::find($incident->contract_id);
            $customer_notifications_email = CustomerNotification::where('department_id', $contract->department_id)->pluck('email')->toArray();
            $incidentUer = [$incident->user->email];
            $admins = User::where('role', 'admin')->pluck('email')->toArray();
            $recipients = array_merge($customer_notifications_email, $admins, $incidentUer);

            EmailService::sendIncidentNotification($incident, $recipients);

            // Create Notification
            // Find the admin or agent you want to notify
            $admins = User::where('role', 'admin')->get(); // Example of getting admins
            foreach ($admins as $admin) {
                $admin->notify(new NewIncidentNotification($incident));
            }
        });
    }

    // constants for incident status
    const STATUS_OPEN = 'open';
    const STATUS_RESOLVED = 'resolved';
    const STATUS_CLOSED = 'closed';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_LABELS = [
        self::STATUS_OPEN => 'Open',
        self::STATUS_RESOLVED => 'Resolved',
        self::STATUS_CLOSED => 'Closed',
        self::STATUS_IN_PROGRESS => 'In Progress',
    ];

    // constants for incident priority
    const PRIORITY_LOW = 'low';
    const PRIORITY_MEDIUM = 'medium';
    const PRIORITY_HIGH = 'high';
    const PRIORITY_CRITICAL = 'critical';
    const PRIORITY_LABELS = [
        self::PRIORITY_LOW => 'Low',
        self::PRIORITY_MEDIUM => 'Medium',
        self::PRIORITY_HIGH => 'High',
        self::PRIORITY_CRITICAL => 'Critical',
    ];

    const INCIDENTTYPE_INCIDENT = 'incident';
    const INCIDENTTYPE_SCHEDULETASK = 'schedule-task';
    const INCIDENTTYPE_PREVENTIVEMAINTENANCE = 'preventive-maintenance';
    const INCIDENTTYPE_LABELS = [
        self::INCIDENTTYPE_INCIDENT => 'Incident',
        self::INCIDENTTYPE_SCHEDULETASK => 'Schedule Task',
        self::INCIDENTTYPE_PREVENTIVEMAINTENANCE => 'Preventive Maintenance',
    ];
}
