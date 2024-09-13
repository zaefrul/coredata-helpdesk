<?php

namespace App\Http\Controllers;

use App\Models\Component;
use Illuminate\Support\Facades\Request;

class ComponentController extends Controller
{
    public function index()
    {
        $components = Component::orderBy('created_at', 'desc')->get();
        return view('component.index', compact('components'));
    }

    public function create()
    {
        return view('component.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'component_type' => 'required',
        ]);
        Component::create($request->all());
        return redirect()->route('components.index')->with('success', 'Component created successfully');
    }

    public function edit(Component $component)
    {
        return view('component.edit', compact('component'));
    }

    public function update(Request $request, Component $component)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'component_type' => 'required',
        ]);
        $component->update($request->all());
        return redirect()->route('components.index')->with('success', 'Component updated successfully');
    }
    
    public function destroy(Component $component)
    {
        $component->delete();
        return redirect()->route('components.index')->with('success', 'Component deleted successfully');
    }
}