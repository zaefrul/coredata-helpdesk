<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Incident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helper\IncidentLogic;
use App\Models\IncidentConversation;
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
        ]);

        DB::beginTransaction();
        
        try
        {
            $contracts = Contract::findOrfail($request->contract_id);
            $incident_number = IncidentLogic::createIncidentNumber($contracts->customer_id);

            Log::info('Creating ticket ' . $incident_number);
    
            $request->merge(['customer_id' => $contracts->customer_id]);
            $request->merge(['user_id' => Auth::user()->id]);
            $request->merge(['status' => 'open']);
            $request->merge(['priority' => 'unasigned']);
            $request->merge(['incident_number' => $incident_number]);
    
            Incident::create($request->all());
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
        $agents = User::where('role', 'agent')
            ->orWhere('role', 'admin')
            ->get();
        $activityLogs = $incident->activityLogs;
        $activityLogs = $activityLogs->reverse(); //show latest first
        // if activity contains comment, get the user, and comments from conversation
        $activityLogs->map(function($activity) {
            if($activity->description == 'Comment added') {
                $activity->user = $activity->user;
                $activity->comment = IncidentConversation::where('id', $activity->comment_id)->first()->message;
            } else if (str_contains($activity->description, 'Changed current_assignee_id')) {
                $activity->user = $activity->user;
                //remove single quote from string
                $activity->description = str_replace("'", "", $activity->description);

                $from = User::where('id', explode(' ', $activity->description)[3])->first();
                $to = User::where('id', explode(' ', $activity->description)[5])->first();

                Log::info($activity->description);
                Log::info(print_r($from, true));
                Log::info(print_r($to, true));

                //construct description with user link to route users.show
                if($from && $to)
                    $activity->description = 'Incident assigned from <a href="'. route('users.show', $from->id) .'">' . $from->name . '</a> to <a href="'. route('users.show', $to->id) .'">' . $to->name . '</a>';
                else
                    $activity->description = 'Incident assigned changed.';
                // $activity->description = 'Incident assigned from <a href="'. route('users.show', $from->id) .'">' . $from->name . '</a> to ' . $to;
            }
        });
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
}