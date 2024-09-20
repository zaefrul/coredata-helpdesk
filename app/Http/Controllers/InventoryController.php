<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InventoryController extends Controller
{
    public function index()
    {
        $inventories = Inventory::all();
        return view('inventory.index', compact('inventories'));
    }

    public function create()
    {
        $component_types = Setting::where('field', 'component_type')->get();
        return view('inventory.create', compact('component_types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'model' => 'required',
            'serial_number' => 'required',
            'part_number' => 'required',
            'description' => 'nullable',
            'type' => 'required',
            'mfg_part_number' => 'nullable'
        ]);

        // change description to item
        $request['item'] = $request->description;

        try
        {
            $inventory = Inventory::create($request->all());
        }
        catch(\Exception $e)
        {
            Log::error($e->getMessage());
            return redirect()->route('inventories.index')
                ->with('error', 'Failed to create inventory. Please contract administrator.');
        }

        return redirect()->route('inventories.index')
            ->with('success', 'Inventory created successfully.');
    }

    public function show($id)
    {
        $inventory = Inventory::find($id);

        if(!$inventory) {
            return redirect()->route('inventories.index')
                ->with('error', 'Inventory not found.');
        }

        return view('inventory.show', compact('inventory'));
    }

    public function edit($id)
    {
        $inventory = Inventory::find($id);
        $component_types = Setting::where('field', 'component_type')->get();
        return view('inventory.edit', compact('inventory', 'component_types'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'model' => 'required',
            'serial_number' => 'required',
            'part_number' => 'required',
            'description' => 'nullable',
            'type' => 'required',
            'mfg_part_number' => 'nullable'
        ]);

        // change description to item
        $request['item'] = $request->description;

        $inventory = Inventory::find($id);

        if(!$inventory) {
            return redirect()->route('inventories.index')
                ->with('error', 'Inventory not found.');
        }

        $inventory->update($request->all());

        return redirect()->route('inventories.index')
            ->with('success', 'Inventory updated successfully');
    }

    public function destroy($id)
    {
        $inventory = Inventory::find($id);

        if(!$inventory) {
            return redirect()->route('inventory.index')
                ->with('error', 'Inventory not found.');
        }

        $inventory->delete();

        return redirect()->route('inventory.index')
            ->with('success', 'Inventory deleted successfully');
    }

    public function search(Request $request)
    {
        try
        {
            $request->validate([
                'search' => 'required'
            ]);
        }
        catch(\Exception $e)
        {
            return response()->json(['error' => $e->getMessage()]);
        }

        try
        {
            $inventories = Inventory::where('model', 'like', '%'.$request->search.'%')
                ->orWhere('serial_number', 'like', '%'.$request->search.'%')
                ->orWhere('part_number', 'like', '%'.$request->search.'%')
                ->orWhere('item', 'like', '%'.$request->search.'%')
                ->orWhere('type', 'like', '%'.$request->search.'%')
                ->orWhere('mfg_part_number', 'like', '%'.$request->search.'%')
                ->get();
        }
        catch(\Exception $e)
        {
            return response()->json(['error' => $e->getMessage()]);
        }

        return response()->json($inventories);
    }
}