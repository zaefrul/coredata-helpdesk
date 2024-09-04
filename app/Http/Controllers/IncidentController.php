<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Incident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncidentController extends Controller 
{
    public function index() {
        $incidents = Incident::all();
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
            'site_location' => 'required',
            'incident_type' => 'required',
        ]);
        
        $contracts = Contract::findOrfail($request->contract_id);
        $request->merge(['customer_id' => $contracts->customer_id]);
        $request->merge(['user_id' => Auth::user()->id]);
        $request->merge(['status' => 'open']);
        $request->merge(['priority' => 'unassigned']);

        Incident::create($request->all());

        return redirect()->route('incidents.index')->with('success', 'Incident created successfully');
    }

    public function show($id) {
        $incident = Incident::find($id);
        return view('incident.show', compact('incident'));
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
            'project_id' => 'required',
        ]);

        $incident = Incident::find($id);
        $incident->update($request->all());
        return redirect()->route('incidents.index');
    }

    public function destroy($id) {
        Incident::destroy($id);
        return redirect()->route('incidents.index');
    }
}