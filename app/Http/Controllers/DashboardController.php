<?php

namespace App\Http\Controllers;

use App\Helper\IncidentLogic;
use App\Models\ActivityLog;
use App\Models\Asset;
use App\Models\Contract;
use App\Models\Incident;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index() {
        $incidents = Incident::all();
        $incidentChartData = $this->getWeeklyIncidentData();
        $incidentPriority = $this->priorityPie();
        $recentIncidents = $this->getTop3RecentActivity();
        return view('dashboard.index', compact('incidents', 'incidentChartData', 'incidentPriority', 'recentIncidents'));
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
}