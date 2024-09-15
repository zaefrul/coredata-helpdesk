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

        return view('customer_view.dashboard.index', compact('recentIncidents', 'recentActivities'));
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
}