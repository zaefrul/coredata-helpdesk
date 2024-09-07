<?php

namespace App\Http\Controllers;

use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        return view('departments.index', compact('departments'));
    }

    public function customerDepartments($customer_id)
    {
        $departments = Department::where('customer_id', $customer_id)->get();
        return response()->json($departments);
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store()
    {
        $data = request()->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        Department::create($data);

        return redirect()->route('departments.index');
    }

    public function show(Department $department)
    {
        return view('departments.show', compact('department'));
    }

    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }

    public function update(Department $department)
    {
        $data = request()->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $department->update($data);

        return redirect()->route('departments.index');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.index');
    }
}