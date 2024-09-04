<?php

namespace App\Helper;

use App\Models\Customer;
use App\Models\Incident;
use Illuminate\Support\Facades\Log;

class IncidentLogic
{
    public static function createIncidentNumber(int $customer_id): string
    {
        // get the last incident number
        Log::info('Creating ticket number for customer ' . $customer_id);
        $lastIncident = Incident::where('customer_id', $customer_id)->orderBy('id', 'desc')->count();
        if ($lastIncident) {
            $newIncidentNumber = $lastIncident + 1;
        } else {
            $newIncidentNumber = 1;
        }

        // get customer prefix select only prefix
        $customerPrefix = Customer::find($customer_id)->prefix;

        // create new incident number
        $newIncidentNumber = $customerPrefix . '-' . $newIncidentNumber;

        return $newIncidentNumber;
    }
}
