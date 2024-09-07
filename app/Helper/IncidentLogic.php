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
}
