<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Customer;
use App\Models\CustomerNotification;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::with('departments')->get();
        Log::info(print_r($customers, true));
        return view('customers.index', compact('customers'));
    }

    public function show($id)
    {
        $customer = Customer::with('departments.notifications')->findOrFail($id);
        return view('customers.show', compact('customer'));
    }

    public function create()
    {
        $users = User::all();
        return view('customers.create', compact('users'));
    }

    public function store()
    {
        $data = request()->validate([
            'company' => 'required',
            'prefix' => 'required',
        ]);

        $customer = new Customer();
        $customer->company_name = request('company');
        $customer->prefix = request('prefix');
        $customer->save();

        $departments = request('departments');

        // if department is not exist then return validation error
        if(!$departments) {
            return back()->withErrors(['departments' => 'Please specify at least one department']);
        }

        foreach($departments as $key => $deparment)
        {
            $data = request()->validate([
                'departments.'.$key.'.department' => 'required',
                'departments.'.$key.'.department_contact_person' => 'nullable',
                'departments.'.$key.'.department_phone_number' => 'nullable',
                'departments.'.$key.'.department_email' => 'nullable|email',
            ]);

            $department = new Department();
            $department->name = $deparment['department'];
            $department->pc_name = $deparment['department_contact_person'] ?? '';
            $department->pc_phone = $deparment['department_phone_number'] ?? '';
            $department->pc_email = $deparment['department_email'] ?? '';
            $department->customer_id = $customer->id;
            $department->save();

            $users_notification = $deparment['department_users_notification'];

            if($users_notification) {
                $users = explode(',', $users_notification);
                foreach($users as $user) {
                    CustomerNotification::create([
                        'department_id' => $department->id,
                        'email' => $user,
                    ]);
                }
            }

            // create user account
            if(User::where('email', $deparment['department_email'])->exists()) {
                continue;
            }

            $user = new User();
            $user->name = $deparment['department_contact_person'];
            $user->email = $deparment['department_email'];
            $user->phone_number = $deparment['department_phone_number'] ?? '';
            $user->password = bcrypt('password');
            $user->customer_id = $customer->id;
            $user->department_id = $department->id;
            $user->save();
        }

        return redirect()->route('customers.index')->with('success', 'Customer created successfully');
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.edit', compact('customer'));
    }

    public function update($id)
    {
        // Validate the incoming data
        $data = request()->validate([
            'company' => 'required',
            'prefix' => 'required',
        ]);

        $customer = Customer::findOrFail($id);

        // Update customer data
        $customer->company_name = request('company');
        $customer->prefix = request('prefix');
        $customer->save();

        // Get the department data
        $departments = request('departments');

        // Validate if departments exist
        if (!$departments) {
            return back()->withErrors(['departments' => 'Please specify at least one department']);
        }

        // Keep track of department IDs that were handled (to delete unneeded ones later)
        $handledDepartmentIds = [];

        foreach ($departments as $key => $departmentData) {
            // Validate the department fields
            $data = request()->validate([
                'departments.' . $key . '.department' => 'required',
                'departments.' . $key . '.department_contact_person' => 'nullable',
                'departments.' . $key . '.department_phone_number' => 'nullable',
                'departments.' . $key . '.department_email' => 'nullable|email',
            ]);

            // Check if the department already exists (edit mode)
            if (isset($departmentData['id'])) {
                // Update existing department
                $department = Department::find($departmentData['id']);
                $handledDepartmentIds[] = $department->id; // Add to handled list

                if ($department) {
                    $department->name = $departmentData['department'];
                    $department->pc_name = $departmentData['department_contact_person'] ?? '';
                    $department->pc_phone = $departmentData['department_phone_number'] ?? '';
                    $department->pc_email = $departmentData['department_email'] ?? '';
                    $department->customer_id = $customer->id;
                    $department->save();
                }
            } else {
                // Create a new department
                $department = new Department();
                $department->name = $departmentData['department'];
                $department->pc_name = $departmentData['department_contact_person'] ?? '';
                $department->pc_phone = $departmentData['department_phone_number'] ?? '';
                $department->pc_email = $departmentData['department_email'] ?? '';
                $department->customer_id = $customer->id;
                $department->save();

                // Add the new department to the handled list
                $handledDepartmentIds[] = $department->id;
            }

            // Handle department user notifications
            $users_notification = $departmentData['department_users_notification'];

            if ($users_notification) {
                $users = explode(',', $users_notification);

                // Delete existing notifications for the department and add new ones
                CustomerNotification::where('department_id', $department->id)->delete();

                foreach ($users as $user) {
                    CustomerNotification::create([
                        'department_id' => $department->id,
                        'email' => $user,
                    ]);
                }
            }

            // check if user already exist
            if (User::where('email', $departmentData['department_email'])->exists()) {
                continue;
            }

            // Create user account
            $user = new User();
            $user->name = $departmentData['department_contact_person'];
            $user->email = $departmentData['department_email'];
            $user->phone_number = $departmentData['department_phone_number'] ?? '';
            $user->password = bcrypt('password');
            $user->customer_id = $customer->id;
            $user->department_id = $department->id;
            $user->save();
        }

        // Remove any departments that were not handled during the update (deleted departments)
        Department::where('customer_id', $customer->id)
            ->whereNotIn('id', $handledDepartmentIds)
            ->delete();

        // Redirect back with a success message
        return redirect()->route('customers.index')->with('success', 'Customer updated successfully');
    }


    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);

        // delete all related departments
        foreach($customer->departments as $department) {
            $department->notifications()->delete();
        }

        // delete projects assets components
        $contracts = Contract::with('assets.components')->where('customer_id', $customer->id)->get();
        foreach($contracts as $contract) {
            foreach($contract->assets as $asset) {
                foreach($asset->components as $component) {
                    $component->delete();
                }
                $asset->delete();
            }
            $contract->delete();
        }

        // delete all users account
        $users = User::where('customer_id', $customer->id)->get();
        foreach($users as $user) {
            $user->delete();
        }

        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully');
    }

    public function index_account()
    {
        $users = User::all();
        return view('customers.account.index', compact('users'));
    }
}