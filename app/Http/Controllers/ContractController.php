<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Customer;
use App\Models\Department;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::all();
        return view('contract.index', compact('contracts'));
    }

    public function show($id)
    {
        $contract = Contract::findOrFail($id);
        return view('contract.show', compact('contract'));
    }

    public function create()
    {
        $customers = Customer::all();
        return view('contract.create', compact('customers'));
    }

    public function store()
    {
        $data = request()->validate([
            'name' => 'required',
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'total_incidence' => 'nullable|numeric|gte:0',
            'total_preventive_maintenance' => 'nullable|numeric|gte:0',
            'total_corrective_maintenance' => 'nullable|numeric|gte:0',
            'customer_id' => 'required',
            'department_id' => 'required',
            'contract_number' => 'required',
            'file' => 'nullable|file|mimes:pdf',
        ]);

        // file upload
        $file_name = null;
        if (request()->hasFile('file')) {
            $file = request()->file('file');
            $file_name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $file_name);
        }

        $total_incidence = request('total_incidence', 0);
        if(request('unlimited_support') == '1') {
            $total_incidence = -1;
        }

        $contract = new Contract();
        $contract->contract_name = request('name');
        $contract->details = request('description');
        $contract->start_date = request('start_date');
        $contract->end_date = request('end_date');
        $contract->total_incidence = $total_incidence;
        $contract->preventive_maintenance = request('total_preventive_maintenance', 0);
        $contract->corrective_maintenance = request('total_corrective_maintenance', 0);
        $contract->customer_id = request('customer_id');
        $contract->department_id = request('department_id');
        $contract->contract_number = request('contract_number');
        $contract->file_name = $file_name;
        $contract->save();

        return redirect()->route('contracts.index')->with('success', 'Contract created successfully');
    }

    public function edit($id)
    {
        $contract = Contract::findOrFail($id);
        $customers = Customer::all();
        $departments = Department::where('customer_id', $contract->customer_id)->get();
        return view('contract.edit', compact('contract', 'customers', 'departments'));
    }

    public function update($id)
    {
        $data = request()->validate([
            'name' => 'required',
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'total_incidence' => 'nullable|numeric|gte:0',
            'total_preventive_maintenance' => 'nullable|numeric|gte:0',
            'total_corrective_maintenance' => 'nullable|numeric|gte:0',
            'customer_id' => 'required',
            'department_id' => 'required',
            'contract_number' => 'required',
        ]);

        $total_incidence = request('total_incidence', 0);
        if(request('unlimited_support') == '1') {
            $total_incidence = -1;
        }

        // file upload
        $file_name = null;
        if(request()->hasFile('file')) {
            $file = request()->file('file');
            $file_name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $file_name);
        }

        $contract = Contract::findOrFail($id);
        $contract->contract_name = request('name');
        $contract->details = request('description');
        $contract->start_date = request('start_date');
        $contract->end_date = request('end_date');
        $contract->total_incidence = $total_incidence;
        $contract->preventive_maintenance = request('total_preventive_maintenance', 0);
        $contract->corrective_maintenance = request('total_corrective_maintenance', 0);
        $contract->customer_id = request('customer_id');
        $contract->department_id = request('department_id');
        $contract->contract_number = request('contract_number');
        $contract->file_name = $file_name;
        $contract->save();

        return redirect()->route('contracts.index')->with('success', 'Contract updated successfully');
    }

    public function destroy($id)
    {
        $contract = Contract::findOrFail($id);

        // delete contracts assets components
        foreach($contract->assets as $asset) {
            foreach($asset->components as $component) {
                $component->delete();
            }
            $asset->delete();
        }

        $contract->delete();

        return redirect()->route('contracts.index')->with('success', 'Contract deleted successfully');
    }
}