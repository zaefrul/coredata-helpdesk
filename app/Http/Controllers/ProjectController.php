<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return view('project.index', compact('projects'));
    }

    public function show($id)
    {
        $project = Project::findOrFail($id);
        return view('project.show', compact('project'));
    }

    public function create()
    {
        $customers = Customer::all();
        return view('project.create', compact('customers'));
    }

    public function store()
    {
        $data = request()->validate([
            'name' => 'required',
            'description' => 'required',
            'customer_id' => 'required',
            'code' => 'required',
        ]);

        $project = new Project();
        $project->name = request('name');
        $project->description = request('description');
        $project->customer_id = request('customer_id');
        $project->code = request('code');
        $project->save();

        return redirect()->route('projects.index')->with('success', 'Project created successfully');
    }

    public function edit($id)
    {
        $project = Project::findOrFail($id);
        return view('project.edit', compact('project'));
    }

    public function update($id)
    {
        $data = request()->validate([
            'name' => 'required',
            'description' => 'required',
            'code' => 'required',
        ]);

        $project = Project::findOrFail($id);
        $project->name = request('name');
        $project->description = request('description');
        $project->code = request('code');
        $project->save();

        return redirect()->route('projects.index')->with('success', 'Project updated successfully');
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);

        // delete all related assets components
        foreach ($project->assets as $asset) {
            $asset->components()->delete();
        }
        
        // delete all assets
        $project->assets()->delete();

        // delete project
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully');
    }
}