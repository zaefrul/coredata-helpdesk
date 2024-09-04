<?php

namespace App\Http\Controllers;

use App\Models\Component;
use App\Models\Customer;
use App\Models\CustomerNotification;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

    public function show($id)
    {
        $customer = Customer::with('notifications')->findOrFail($id);
        Log::info($customer);
        return view('customers.show', compact('customer'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store()
    {
        $data = request()->validate([
            'company' => 'required',
            'contact_person' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'prefix' => 'required',
            'users_notification' => 'nullable',
        ]);

        $users_notification = request('users_notification');

        

        $customer = new Customer();
        $customer->company_name = request('company');
        $customer->contact_person = request('contact_person');
        $customer->email = request('email');
        $customer->phone_number = request('phone_number');
        $customer->prefix = request('prefix');
        $customer->save();

        if($users_notification) {
            $users = explode(',', $users_notification);
            foreach($users as $user) {
                CustomerNotification::create([
                    'customer_id' => $customer->id,
                    'email' => $user,
                ]);
            }
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
        $data = request()->validate([
            'company' => 'required',
            'contact_person' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'prefix' => 'required',
            'users_notification' => 'nullable',
        ]);

        $customer = Customer::findOrFail($id);
        $customer->company_name = request('company');
        $customer->contact_person = request('contact_person');
        $customer->email = request('email');
        $customer->phone_number = request('phone_number');
        $customer->prefix = request('prefix');
        $customer->save();

        $users_notification = request('users_notification');
        if($users_notification) {
            $users = explode(',', $users_notification);
            CustomerNotification::where('customer_id', $customer->id)->delete();
            foreach($users as $user) {
                CustomerNotification::create([
                    'customer_id' => $customer->id,
                    'email' => $user,
                ]);
            }
        } else {
            CustomerNotification::where('customer_id', $customer->id)->delete();
        }

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully');
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully');
    }

    public function index_account()
    {
        $users = User::all();
        return view('customers.account.index', compact('users'));
    }
}