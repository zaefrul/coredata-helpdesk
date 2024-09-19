<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Incident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helper\IncidentLogic;
use App\Models\Asset;
use App\Models\Component;
use App\Models\IncidentConversation;
use App\Models\Inventory;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class IncidentController extends Controller 
{
    public function index() {
        $incidents = Incident::orderBy('created_at', 'desc')->get();
        return view('incident.index', compact('incidents'));
    }

    public function create() {
        $contracts = Contract::all();
        return view('incident.create', compact('contracts'));
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'contract_id' => 'required',
            'asset_id' => 'required',
            'site_location' => 'nullable',
            'incident_type' => 'required',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png',
        ]);

        DB::beginTransaction();
        
        try
        {
            $contracts = Contract::findOrfail($request->contract_id);
            $incident_number = $request->incident_type == "incident" ? IncidentLogic::createIncidentNumber($contracts->customer_id) : IncidentLogic::createScheduleTaskNumber($contracts->customer_id);

            Log::info('Creating ticket ' . $incident_number);
    
            $request->merge(['customer_id' => $contracts->customer_id]);
            $request->merge(['user_id' => Auth::user()->id]);
            $request->merge(['status' => 'open']);
            $request->merge(['priority' => 'unasigned']);
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

            DB::commit();
    
            return redirect()->route('incidents.index')->with('success', 'Incident created successfully');    
        }
        catch(\Exception $e)
        {
            DB::rollback();
            Log::error($e->getMessage());
            return redirect()->route('incidents.index')->with('error', 'Incident creation failed');
        }
    }

    public function show($id) {
        $incident = Incident::where('incident_number', $id)->first();
        if(!$incident) {
            return back()->with('error', 'Incident not found');
        }

        if(Auth::user()->role == 'agent') {
            $agents = User::where('id', Auth::id())->get();
        }
        else {
            $agents = User::where('role', 'agent')
                ->orWhere('role', 'admin')
                ->get();
        }
        $activityLogs = $incident->activityLogs;
        $activityLogs = $activityLogs->reverse(); //show latest first
        $activityLogs = IncidentLogic::processActivityLogsDescription($activityLogs);

        return view('incident.show', compact('incident', 'agents', 'activityLogs'));
    }

    public function edit($id) {
        $incident = Incident::find($id);
        return view('incident.edit', compact('incident'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'severity' => 'required',
            'status' => 'required',
            'customer_id' => 'required',
            'contract_id' => 'required',
        ]);

        $incident = Incident::find($id);
        $incident->update($request->all());
        return redirect()->route('incidents.index');
    }

    public function destroy($id) {
        Incident::destroy($id);
        return redirect()->route('incidents.index');
    }

    public function assign(Request $request, Incident $incident)
    {
        // Validate the request to ensure a valid assignee_id is provided
        $request->validate([
            'assignee_id' => 'required|exists:users,id',
        ]);

        // Assign the incident to the selected agent
        $incident->current_assignee_id = $request->input('assignee_id');
        $incident->save();

        return back()->with('success', 'Incident assigned successfully');
    }

    public function status(Request $request, Incident $incident)
    {
        // Validate the request to ensure a valid status is provided
        $request->validate([
            'status' => 'required|in:open,in_progress,resolved,closed',
        ]);

        // Update the status of the incident
        $incident->status = $request->input('status');
        $incident->save();

        return back()->with('success', 'Incident status updated successfully');
    }

    public function priority(Request $request, Incident $incident)
    {
        // Validate the request to ensure a valid priority is provided
        $request->validate([
            'priority' => 'required|in:unasigned,low,medium,high,critical',
        ]);

        // Update the priority of the incident
        $incident->priority = $request->input('priority');
        $incident->save();

        return back()->with('success', 'Incident priority updated successfully');
    }

    public function comment(Request $request, Incident $incident)
    {
        // Validate the request to ensure a valid comment is provided
        $request->validate([
            'comment' => 'required',
        ]);

        $convo = new IncidentConversation();

        $convo->incident_id = $incident->id;
        $convo->user_id = Auth::id();
        $convo->message = $request->input('comment');

        $convo->save();

        return back()->with('success', 'Comment added successfully');
    }

    public function replacePart(Request $request, $id)
    {
        // Validate the request to ensure a valid part_id is provided
        try
        {
            $request->validate([
                'inventoryId' => 'required|exists:inventories,id',
                'componentId' => 'required|exists:components,id',
                'incidentId' => 'required|exists:incidents,id',
            ]);

            // Find the incident by id
            $incident = Incident::findOrFail($id);

            // Find the inventory by id
            $inventory = Inventory::findOrFail($request->input('inventoryId'));

            // Find the component by id
            $component = Component::findOrFail($request->input('componentId'));

            DB::beginTransaction();

            $inventory->replaced_incident_id = $incident->id;
            $inventory->save();

            // create new inventory with replaced incident id
            $newInventory = new Inventory();
            $newInventory->model = $component->component_model;
            $newInventory->serial_number = $component->serial_number;
            $newInventory->part_number = $component->part_number;
            $newInventory->item = $component->component_name;
            $newInventory->type = $component->component_type;
            $newInventory->replaced_incident_id = $incident->id;
            $newInventory->old_item = $inventory->id;
            $newInventory->save();

            $component->component_model = $inventory->model;
            $component->serial_number = $inventory->serial_number;
            $component->part_number = $inventory->part_number;
            $component->component_name = $inventory->item;
            $component->save();

            
        }
        catch(\Exception $e)
        {
            Log::info($e->getMessage());
            return response()->json(['error' => $e->getMessage()]);
            DB::rollback();
        }
        
        DB::commit();

        // write changes to activity Logs
        $incident->activityLogs()->create([
            'user_id' => Auth::id(),
            'incident_id' => $incident->id,
            'description' => "Component Replaced: '" . $newInventory->id . "' is replaced with '". $inventory->id ."'",
        ]);

        
        return response()->json(['success' => 'Part replaced successfully']);
    }

    public function uploadAttachment(Request $request)
    {
        // Validate that files have been uploaded
        $request->validate([
            'incident_id' => 'required|exists:incidents,id',
            'attachments.*' => 'required|file|mimes:jpg,jpeg,png',
        ]);
        
        $incident = Incident::findOrFail($request->incident_id);

        $paths = [];

        // Check if files are uploaded
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

        return back()->with('success', 'Images uploaded successfully');
    }

    public function updateStatusFromKanban(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:incidents,incident_number',
            'status' => 'required|in:open,in_progress,resolved,closed',
        ]);

        Log::info('Updating ticket status from kanban ' . $request->id);

        $incident = Incident::where('incident_number', $request->id)->first();

        if(!$incident) {
            return redirect()->route('dashboard3')->with('error', 'Incident not found');
        }

        $incident->status = $request->status;
        $incident->save();

        return redirect()->route('dashboard3')->with('success', 'Incident '.$incident->incident_number.' status updated successfully');
    }
}