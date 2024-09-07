<?php

namespace App\Models;

use App\Scopes\IncludeTrashedScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
