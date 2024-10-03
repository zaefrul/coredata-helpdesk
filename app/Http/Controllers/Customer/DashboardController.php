<?php

namespace App\Http\Controllers\Customer;

use App\Helper\IncidentLogic;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Incident;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        $recentIncidents = $this->getTop5RecentIncidents();
        $recentActivities = $this->getTop3RecentActivity();
        $incidentNoByContract = $this->getTop5TotalIncidentByContract();

        return view('customer_view.dashboard.index', compact('recentIncidents', 'recentActivities', 'incidentNoByContract'));
    }

    private function getTop5RecentIncidents()
    {
        $departmentId = Auth::user()->department_id; // Assuming user is tied to a department
        $recent_incidents = Incident::whereHas('asset.contract', function($query) use ($departmentId) {
            $query->where('department_id', $departmentId);
        })->with('asset.contract.department')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get(); // to get the recent 5 incidents;
        return $recent_incidents;
    }

    private function getTop3RecentActivity()
    {
        //top 3 recent activities
        $departmentId = Auth::user()->department_id; // Assuming user is tied to a department

        $recentActivities = ActivityLog::whereHas('incident.asset.contract', function($query) use ($departmentId) {
            $query->where('department_id', $departmentId);
        })->with('incident.asset.contract.department')
        ->orderBy('created_at', 'desc')
        ->limit(5) // to get the recent 5 activities
        ->get();

        IncidentLogic::processActivityLogsDescription($recentActivities);

        // replace the user_id with the user name
        $recentActivities->transform(function ($activityLog) {
            $activityLog->user_id = $activityLog->user->name;
            return $activityLog;
        });

        // replace incident_id with the incident_number
        $recentActivities->transform(function ($activityLog) {
            $activityLog->incident_id = $activityLog->incident->incident_number;
            return $activityLog;
        });

        return $recentActivities;
    }

    function getTop5TotalIncidentByContract()
    {
        $departmentId = Auth::user()->department_id; // Assuming user is tied to a department
        $incidents = Incident::whereHas('asset.contract', function($query) use ($departmentId) {
            $query->where('department_id', $departmentId);
        })
            ->with('asset.contract.department') // Eager load the necessary relationships
            ->selectRaw('count(*) as total_incidents, contract_id, contracts.contract_number, customers.prefix') // Include contract_number
            ->join('contracts', 'incidents.contract_id', '=', 'contracts.id') // Join the contracts table
            ->join('customers', 'contracts.customer_id', '=', 'customers.id') // Join the customers table
            ->groupBy('contract_id', 'contracts.contract_number', 'customers.prefix') // Group by contract_id and contract_number
            ->orderBy('total_incidents', 'desc')
            ->limit(5)
            ->get(); // to get the top 5 contracts with the highest number of incidents

        Log::info(print_r($incidents, true));
        return $incidents;
    }
}