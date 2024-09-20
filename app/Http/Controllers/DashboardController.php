<?php

namespace App\Http\Controllers;

use App\Helper\IncidentLogic;
use App\Models\ActivityLog;
use App\Models\Asset;
use App\Models\Contract;
use App\Models\Incident;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index() {
        $incidents = Incident::all();
        $incidentChartData = $this->getWeeklyIncidentData();
        $incidentPriority = $this->priorityPie();
        $incidentStatus = $this->statusPie();
        $recentIncidents = $this->getTop3RecentActivity();
        $incidentByQuarter = $this->barChartIncidentByQuarter();
        $contracts = $this->topContractWithIncidents();
        return view('dashboard.index', compact('incidents', 'incidentChartData', 'incidentPriority', 'incidentStatus', 'recentIncidents', 'incidentByQuarter', 'contracts'));
    }

    public function getIncidentChartData()
    {
        // Get current date
        $today = Carbon::today();

        // Get the date 15 days ago
        $startDate = $today->subDays(15);

        // Query incidents created in the last 15 days, group by day
        $incidents = Incident::whereBetween('created_at', [$startDate, Carbon::now()])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Prepare the date range labels (15 days back from today)
        $labels = [];
        $incidentData = [];
        $currentDate = Carbon::now();
        for ($i = 0; $i <= 15; $i++) {
            $dateLabel = $currentDate->format('jS M');
            $labels[] = $dateLabel;

            // Check if there is data for this specific day
            $incidentOnDate = $incidents->firstWhere('date', $currentDate->format('Y-m-d'));
            $incidentData[] = $incidentOnDate ? $incidentOnDate->count : 0;

            // Move to the previous day
            $currentDate->subDay();
        }

        // Reverse the order to make sure the chart displays from the oldest date to the most recent
        $labels = array_reverse($labels);
        $incidentData = array_reverse($incidentData);

        // Return chart data in the required format
        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Incidents',
                    'color' => '#4CAF50', // Set color as required
                    'borderWidth' => 2,
                    'data' => $incidentData,
                    'pointBorderColor' => 'transparent',
                    'pointBackgroundColor' => 'transparent',
                    'pointHoverBackgroundColor' => '#4CAF50',
                ]
            ]
        ];
    }

    public function getYearlyIncidentData() {
        // Initialize an empty array
        $incidentsPerMonth = [];
    
        // Prepare the last 12 months array (keyed by year-month) and initialize with 0 incidents
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i)->format('Y-m');
            $incidentsPerMonth[$date] = 0; // Ensure that each month has a 0 value initially
        }
    
        // Get incidents grouped by month
        $incidentData = Incident::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
            ->where('created_at', '>=', Carbon::now()->subYear())
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
    
        // Iterate through the incidents data and assign the totals
        foreach ($incidentData as $data) {
            $dateKey = Carbon::createFromDate($data->year, $data->month, 1)->format('Y-m');
            // Ensure that only valid dates are updated
            if (array_key_exists($dateKey, $incidentsPerMonth)) {
                $incidentsPerMonth[$dateKey] = $data->total;
            }
        }
    
        // Prepare the chart data
        $incidentChart = [
            'labels' => array_keys($incidentsPerMonth),  // Use the months as labels
            'datasets' => [
                [
                    'label' => 'Incidents per Month',
                    'color' => '#2dc58c',
                    'borderWidth' => 2,
                    'backgroundGradient' => '#2dc58c',
                    'data' => array_values($incidentsPerMonth),  // Use the incidents count as the data
                ]
            ]
        ];
    
        return $incidentChart;
    }

    public function getWeeklyIncidentData() {
        // Initialize an empty array to hold the incidents per week
        $incidentsPerWeek = [];
    
        // Prepare the last 15 weeks array (keyed by year-week) and initialize with 0 incidents
        for ($i = 14; $i >= 0; $i--) {
            $startOfWeek = Carbon::now()->subWeeks($i)->startOfWeek();
            $endOfWeek = Carbon::now()->subWeeks($i)->endOfWeek();
            $weekKey = $startOfWeek->format('Y W'); // Year and Week number (ISO-8601)
            $incidentsPerWeek[$weekKey] = 0; // Ensure that each week has a 0 value initially
        }
    
        // Get incidents grouped by week (ISO week format)
        $incidentData = Incident::selectRaw('YEARWEEK(created_at, 1) as year_week, COUNT(*) as total')
            ->where('created_at', '>=', Carbon::now()->subWeeks(15)->startOfWeek())
            ->groupBy('year_week')
            ->orderBy('year_week', 'asc')
            ->get();
    
        // Iterate through the incidents data and assign the totals
        foreach ($incidentData as $data) {
            $yearWeek = $data->year_week;
            $year = substr($yearWeek, 0, 4); // Extract the year
            $week = substr($yearWeek, 4); // Extract the week number
    
            // Use Carbon to generate a readable label
            $startOfWeek = Carbon::now()->setISODate($year, $week)->startOfWeek();
            $weekKey = $startOfWeek->format('Y W'); // Year and Week number
    
            // Ensure that only valid weeks are updated
            if (array_key_exists($weekKey, $incidentsPerWeek)) {
                $incidentsPerWeek[$weekKey] = $data->total;
            }
        }
    
        // Prepare the chart data
        $incidentChart = [
            'labels' => array_keys($incidentsPerWeek),  // Use the weeks as labels (e.g., "2023 W40")
            'datasets' => [
                [
                    'label' => 'Incidents per Week',
                    'color' => '#2dc58c',
                    'borderWidth' => 2,
                    'backgroundGradient' => '#2dc58c',
                    'data' => array_values($incidentsPerWeek),  // Use the incidents count as the data
                ]
            ]
        ];
    
        return $incidentChart;
    }

    public function priorityPie()
    {
        // Query to get the count of incidents based on their priority
        $incidentPriority = Incident::selectRaw('priority, COUNT(*) as total')
            ->groupBy('priority')
            ->pluck('total', 'priority');
        
        return $incidentPriority;
    }

    public function getTop3RecentActivity()
    {
        //top 3 recent activities
        $activityLogs = ActivityLog::latest()->take(5)->get();

        IncidentLogic::processActivityLogsDescription($activityLogs);

        // replace the user_id with the user name
        $activityLogs->transform(function ($activityLog) {
            $activityLog->user_id = $activityLog->user->name;
            return $activityLog;
        });

        // replace incident_id with the incident_number
        $activityLogs->transform(function ($activityLog) {
            $activityLog->incident_id = $activityLog->incident->incident_number;
            return $activityLog;
        });

        Log::info(print_r($activityLogs, true));

        return $activityLogs;
    }

    public function statusPie()
    {
        // Query to get the count of incidents based on their status
        $incidentStatus = Incident::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');
        
        return $incidentStatus;
    }

    public function barChartIncidentByQuarter()
    {
        // Get the current year
        $currentYear = Carbon::now()->year;

        // Get the incidents grouped by quarter
        $incidentData = Incident::selectRaw('QUARTER(created_at) as quarter, COUNT(*) as total')
            ->whereYear('created_at', $currentYear)
            ->groupBy('quarter')
            ->orderBy('quarter', 'asc')
            ->get();

        // Prepare the chart data
        $incidentChart = [
            'labels' => ['Q1', 'Q2', 'Q3', 'Q4'],
            'datasets' => [
                [
                    'label' => 'Incidents by Quarter',
                    'color' => '#2dc58c',
                    'borderWidth' => 2,
                    'backgroundGradient' => '#2dc58c',
                    'data' => [0, 0, 0, 0],  // Initialize with 0 incidents for each quarter
                ]
            ]
        ];

        // Iterate through the incidents data and assign the totals
        foreach ($incidentData as $data) {
            $quarter = $data->quarter;
            $incidentChart['datasets'][0]['data'][$quarter - 1] = $data->total;
        }

        return $incidentChart;
    }

    // kanban
    public function indexKanban()
    {
        // construct kanban board
        if(Auth::user()->role == 'admin') {
            $incidents = Incident::all();
        } else {
            $incidents = Incident::where('current_assignee_id', Auth::user()->id)->get();
        }

        $kanban = [
            'open' => [],
            'in_progress' => [],
            'resolved' => [],
            'closed' => []
        ];

        // loop through incidents and assign to the appropriate column
        foreach ($incidents as $incident) {

            $classSpan = '';

            if($incident->priority == 'low' && $incident->status == 'open' && $incident->created_at->diffInHours() > 24) {
                $classSpan = 'text-danger';
            } 
            else if($incident->priority == 'medium' && $incident->status == 'open' && $incident->created_at->diffInHours() > 8) {
                $classSpan = 'text-danger';
            } 
            else if($incident->priority == 'high' && $incident->status == 'open' && $incident->created_at->diffInHours() > 4) {
                $classSpan = 'text-danger';
            } 
            else if($incident->priority == 'critical' && $incident->status == 'open' && $incident->created_at->diffInHours() > 2) {
                $classSpan = 'text-danger';
            }

            $incidentNoNTitle = '<a class="link-dark" href="/incidents/' . $incident->incident_number . '/show"><span class="fw-bold ' . $classSpan . '">' . $incident->incident_number . '</span>: ' . $incident->title . '</a>';
            $warning = $classSpan != '' ? '<div class="text-small text-danger fst-italic">*Breaking SLA</span>' : '';
            $incidentDate = '<div class="text-muted">' . $incident->created_at->diffForHumans() . '</div>';
            if($incident->priority == 'critical') {
                $priority = '<span class="badge text-bg-danger"> ' . ucfirst($incident->priority) . '</span>';
            } else if ($incident->priority == 'high') {
                $priority = '<span class="badge text-bg-danger-soft"> ' . ucfirst($incident->priority) . '</span>';
            } else if ($incident->priority == 'medium') {
                $priority = '<span class="badge text-bg-warning">' . ucfirst($incident->priority) . '</span>';
            } else {
                $priority = '<span class="badge text-bg-info">' . ucfirst($incident->priority) . '</span>';
            }
                
            // $priority = '<div class="text-muted">: ' . ucfirst($incident->priority) . '</div>';

            $assignee = $incident->currentAssignee ? $incident->currentAssignee->name : 'Unassigned';

            $assignTo = '<div class="text-muted">Assigned to: <strong class="text-info">' . $assignee . '</strong></div>';
        

            $item = [
                'id' => $incident->id,
                'title' => '<div>' . $incidentNoNTitle . $warning . $assignTo . $priority . '</div>',
            ];

            switch ($incident->status) {
                case 'open':
                    $kanban['open'][] = $item;
                    break;
                case 'in_progress':
                    $kanban['in_progress'][] = $item;
                    break;
                case 'resolved':
                    $kanban['resolved'][] = $item;
                    break;
                case 'closed':
                    $kanban['closed'][] = $item;
                    break;
            }
        }

        return view('dashboard.kanban', compact('kanban'));
    }

    public function topContractWithIncidents()
    {
        // Get the top 5 contracts with the most incidents
        $incidents = Incident::selectRaw('contract_id, COUNT(*) as total')
            ->groupBy('contract_id')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();

        // Get the contract details for each incident
        $contracts = [];
        foreach ($incidents as $incident) {
            $contract = Contract::find($incident->contract_id);
            if ($contract) {
                $name = '<a class="link-dark" href="'. route('contracts.show', $contract->id) .'"><strong>' . $contract->customer->prefix . '</strong> - ' . $contract->contract_number . '</a>';
                $contracts[] = [
                    'contract_id' => $contract->id,
                    'contract_name' => $name,
                    'total_incidents' => $incident->total,
                ];
            }
        }

        return $contracts;
    }
}