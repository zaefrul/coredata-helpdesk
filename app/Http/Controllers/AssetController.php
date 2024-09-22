<?php

namespace App\Http\Controllers;

use App\Helper\AssetHelper;
use App\Models\Asset;
use App\Models\Component;
use App\Models\Contract;
use App\Models\Project;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{
    public function index()
    {
        $assets = Asset::all();
        return view('asset.index', compact('assets'));
    }

    public function create()
    {
        if(Auth::user()->role == 'agent')
        {
            return redirect()->route('assets.index')
                ->with('error', 'You are not authorized to create an asset');
        }
        $contracts = Contract::all();
        $component_types = Setting::where('field', 'component_type')->get();
        return view('asset.create', compact('contracts', 'component_types'));
    }

    public function store(Request $request)
    {   
        $request->validate([
            'name' => 'required',
            'brand' => 'required',
            'serial_number' => 'nullable',
            'category' => 'required',
            'contract_id' => 'required',
            'details' => 'nullable',
            'purchased_date' => 'required_unless:same_as_contract,1|date_format:d/m/Y',
            'warranty_end' => 'required_unless:same_as_contract,1|date_format:d/m/Y',
            'warranty_level' => 'required',
            'location' => 'nullable',
            'same_as_contract' => 'nullable',
        ]);

        if(request()->has('same_as_contract')) {
            $contract = Contract::findOrFail($request->contract_id);
            $request->merge([
                'purchased_date' => $contract->start_date,
                'warranty_end' => $contract->end_date,
            ]);
        }
        else {
            $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', request()->purchased_date)->format('Y-m-d');
            $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', request()->warranty_end)->format('Y-m-d');
            
            // Add the converted dates back into the request
            request()->merge([
                'purchased_date' => $startDate,
                'warranty_end' => $endDate,
            ]);
        }
    
        $asset = new Asset();

        $asset->name = $request->name;
        $asset->brand = $request->brand;
        $asset->serial_number = $request->serial_number;
        $asset->category = $request->category;
        $asset->contract_id = $request->contract_id;
        $asset->details = $request->details;
        $asset->purchased_date = $request->purchased_date;
        $asset->warranty_end = $request->warranty_end;
        $asset->warranty_level = $request->warranty_level;
        $asset->location = $request->location;
        $asset->save();

        // Check if there are any components to save
        if ($request->has('components')) {
            foreach ($request->input('components') as $componentData) {
                // Validate each component data
                $componentValidatedData = \Illuminate\Support\Facades\Validator::make($componentData, [
                    'name' => 'required|string|max:255',
                    'serial' => 'required|string|max:255',
                    'part' => 'nullable|string|max:255',
                    'type' => 'required|string|max:255',
                    'item' => 'nullable|string|max:255',
                ])->validate();

                // Create the AssetComponent and associate it with the Asset
                $assetComponent = new Component();
                $assetComponent->component_model = $componentValidatedData['name'];
                $assetComponent->serial_number = $componentValidatedData['serial'];
                $assetComponent->part_number = $componentValidatedData['part'];
                $assetComponent->component_name = $componentValidatedData['item'];
                $assetComponent->component_type = $componentValidatedData['type'];
                $asset->components()->save($assetComponent);
            }
        }

        // Generate the asset_number
        $asset->asset_number = AssetHelper::generateAssetNumber($asset);
        $asset->save();

        // Update the asset with the QR code path
        $asset->qr_code_path = \App\Helper\AssetHelper::generateAssetQRCode($asset);
        $asset->save();

        return redirect()->route('assets.index')
            ->with('success', 'Asset created successfully.');
    }

    public function show($id)
    {
        $asset = Asset::findOrFail($id);
        return view('asset.show', compact('asset'));
    }

    public function edit($id)
    {
        if(Auth::user()->role == 'agent')
        {
            return redirect()->route('assets.index')
                ->with('error', 'You are not authorized to edit an asset');
        }
        $asset = Asset::findOrFail($id);
        $contracts = Contract::all();
        $component_types = Setting::where('field', 'component_type')->get();
        return view('asset.edit', compact('asset', 'contracts', 'component_types'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'brand' => 'required',
            'serial_number' => 'nullable',
            'category' => 'required',
            'contract_id' => 'required',
            'details' => 'nullable',
            'purchased_date' => 'required|date_format:d/m/Y',
            'warranty_end' => 'required|date_format:d/m/Y',
            'warranty_level' => 'required',
            'location' => 'nullable'
        ]);

        $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', request()->purchased_date)->format('Y-m-d');
        $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', request()->warranty_end)->format('Y-m-d');

        // Add the converted dates back into the request
        request()->merge([
            'purchased_date' => $startDate,
            'warranty_end' => $endDate,
        ]);
        
        $asset = Asset::findOrFail($id);

        $asset->name = $request->name;
        $asset->brand = $request->brand;
        $asset->serial_number = $request->serial_number;
        $asset->category = $request->category;
        $asset->contract_id = $request->contract_id;
        $asset->details = $request->details;
        $asset->purchased_date = $request->purchased_date;
        $asset->warranty_end = $request->warranty_end;
        $asset->warranty_level = $request->warranty_level;
        $asset->location = $request->location;
        $asset->save();

        // Handle components
        $existingComponentIds = $asset->components->pluck('id')->toArray();
        $incomingComponentIds = [];

        if ($request->has('components')) {
            foreach ($request->input('components') as $componentData) {
                // Validate each component data
                $componentValidatedData = \Illuminate\Support\Facades\Validator::make($componentData, [
                    'id' => 'nullable|integer|exists:components,id',
                    'name' => 'required|string|max:255',
                    'serial' => 'required|string|max:255',
                    'part' => 'nullable|string|max:255',
                    'type' => 'required|string|max:255',
                    'item' => 'nullable|string|max:255',
                ])->validate();

                if (isset($componentValidatedData['id'])) {
                    // This component already exists; update it
                    $component = Component::findOrFail($componentValidatedData['id']);
                    $component->update([
                        'component_model' => $componentValidatedData['name'],
                        'serial_number' => $componentValidatedData['serial'],
                        'part_number' => $componentValidatedData['part'],
                        'component_name' => $componentValidatedData['item'],
                        'component_type' => $componentValidatedData['type'],
                    ]);
                    $incomingComponentIds[] = $component->id;
                } else {
                    // This is a new component; create it
                    $assetComponent = new Component([
                        'component_model' => $componentValidatedData['name'],
                        'serial_number' => $componentValidatedData['serial'],
                        'part_number' => $componentValidatedData['part'],
                        'component_name' => $componentValidatedData['item'],
                        'component_type' => $componentValidatedData['type'],
                    ]);
                    $asset->components()->save($assetComponent);
                    $incomingComponentIds[] = $assetComponent->id;
                }
            }
        }

        // Handle deletion of components not in the incoming request
        $componentsToDelete = array_diff($existingComponentIds, $incomingComponentIds);
        Component::destroy($componentsToDelete);
        
        return redirect()->route('assets.index')
            ->with('success', 'Asset updated successfully');
    }

    public function destroy($id)
    {
        $asset = Asset::findOrFail($id);
        $asset->delete();

        return redirect()->route('assets.index')
            ->with('success', 'Asset deleted successfully');
    }

    public function getAssetByContractorId(Request $request)
    {
        $contractId = $request->contract_id;
        $assets = Asset::where('contract_id', $contractId)->get();
        return response()->json($assets);
    }
}