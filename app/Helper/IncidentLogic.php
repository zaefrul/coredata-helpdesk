<?php

namespace App\Helper;

use App\Models\Customer;
use App\Models\Incident;
use App\Models\IncidentConversation;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class IncidentLogic
{
    public static function createIncidentNumber(int $customer_id): string
    {
        // get the last incident number
        $lastIncident = Incident::where('customer_id', $customer_id)->orderBy('id', 'desc')->count();
        if ($lastIncident) {
            $newIncidentNumber = $lastIncident + 1;
        } else {
            $newIncidentNumber = 1;
        }

        // get customer prefix select only prefix
        $customerPrefix = Customer::find($customer_id)->prefix;

        // replace all spaces with hyphen and remove leading and trailing hyphens
        $customerPrefix = trim(preg_replace('/\s+/', '-', $customerPrefix), '-');

        // create new incident number
        $newIncidentNumber = $customerPrefix . '-' . $newIncidentNumber;

        return $newIncidentNumber;
    }

    public static function processActivityLogsDescription($activityLogs, $skipComment = false)
    {
        if(!isset($activityLogs)) return;
        $activityLogs->map(function($activity) use ($skipComment) {
            if($activity->description == 'Comment added' && !$skipComment) {
                $activity->user = $activity->user;
                $activity->comment = IncidentConversation::where('id', $activity->comment_id)->first()->message;
            } else if (str_contains($activity->description, 'Changed current_assignee_id')) {
                $activity->user = $activity->user;
                //remove single quote from string
                $activity->description = str_replace("'", "", $activity->description);

                $from = User::where('id', explode(' ', $activity->description)[3])->first();
                $to = User::where('id', explode(' ', $activity->description)[5])->first();

                //construct description with user link to route users.show
                if($from && $to)
                    $activity->description = 'Incident assigned from <a href="'. route('users.show', $from->id) .'">' . $from->name . '</a> to <a href="'. route('users.show', $to->id) .'">' . $to->name . '</a>';
                else
                    $activity->description = 'Incident assigned changed.';
                // $activity->description = 'Incident assigned from <a href="'. route('users.show', $from->id) .'">' . $from->name . '</a> to ' . $to;
            }

            $activity->description = str_replace(
                ["'open'", "'in_progress'", "'resolved'", "'closed'"],
                [
                    '<span class="badge text-bg-info fs-6">Open</span>',
                    '<span class="badge text-bg-info fs-6">In Progress</span>',
                    '<span class="badge text-bg-success fs-6">Resolved</span>',
                    '<span class="badge text-bg-warning fs-6">Closed</span>'
                ],
                $activity->description
            );

            $activity->description = str_replace(
                ["'unasigned'", "'low'", "'medium'", "'high'", "'critical'"],
                [
                    '<span class="badge text-bg-light fs-6">Unassigned <em class="icon ni ni-cross"></em></span>',
                    '<span class="badge text-bg-info fs-6">Low <em class="icon ni ni-chevrons-down"></em></span>',
                    '<span class="badge text-bg-warning fs-6">Medium <em class="icon ni ni-chevron-down"></em></span>',
                    '<span class="badge text-bg-danger-soft fs-6">High <em class="icon ni ni-chevron-up"></em></span>',
                    '<span class="badge text-bg-danger fs-6">Critical <em class="icon ni ni-chevrons-up"></em></span>'
                ],
                $activity->description
            );
        });

        return $activityLogs;
    }
}
