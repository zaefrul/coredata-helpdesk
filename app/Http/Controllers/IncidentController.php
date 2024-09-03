<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Incident;
use Illuminate\Http\Request;

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
            'severity' => 'required',
            'status' => 'required',
            'customer_id' => 'required',
            'project_id' => 'required',
        ]);

        Incident::create($request->all());
        return redirect()->route('incidents.index');
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