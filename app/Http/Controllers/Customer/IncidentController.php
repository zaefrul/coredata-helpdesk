<?php

namespace App\Http\Controllers\Customer;

use App\Helper\IncidentLogic;
use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Incident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncidentController extends Controller
{
    public function index()
    {
        $incidents = Incident::where('customer_id', Auth::user()->customer_id)->get();
        return view('customer_view.incident.index', compact('incidents'));
    }

    public function show($id)
    {
        $incident = Incident::where('incident_number', $id)->first();
        $activityLogs = $incident->activityLogs()->orderBy('created_at', 'desc')->get();

        $activityLogs = IncidentLogic::processActivityLogsDescription($activityLogs);

        if (!$incident) {
            return redirect()->route('incidents.index')->with('error', 'Incident not found. Please check with the agent.');
        }

        return view('customer_view.incident.show', compact('incident', 'activityLogs'));
    }

    public function create()
    {
        $contracts = Contract::where('customer_id', Auth::user()->customer_id)
            ->where('department_id', Auth::user()->department_id)
            ->get();
        return view('customer_view.incident.create', compact('contracts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'contract_id' => 'required',
            'asset_id' => 'required',
            'site_location' => 'nullable',
            'priority' => 'required',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png',
        ]);

        $contracts = Contract::findOrfail($request->contract_id);
        $incident_number = IncidentLogic::createIncidentNumber($contracts->customer_id);

        $request->merge(['customer_id' => $contracts->customer_id]);
        $request->merge(['user_id' => Auth::user()->id]);
        $request->merge(['status' => 'open']);
        $request->merge(['priority' => $request->priority]);
        $request->merge(['incident_number' => $incident_number]);

        $incident = Incident::create($request->all());

        // Upload attachments
        if ($request->hasFile('attachments')) {
            $paths = IncidentLogic::attachmentUploadHandler($request, $incident);
            // build json array of paths
            $paths = json_encode($paths);
            $description = "Attachments : " . $paths;

            // activityLogs
            $incident->activityLogs()->create([
                'user_id' => Auth::id(),
                'incident_id' => $incident->id,
                'description' => $description,
            ]);
        }

        return redirect()->route('user.incidents.index')->with('success', 'Incident created successfully');
    }
}