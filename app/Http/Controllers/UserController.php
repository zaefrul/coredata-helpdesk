<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('user.show', compact('user'));
    }

    public function create()
    {
        $customers = Customer::all();
        return view('user.create', compact('customers'));
    }

    public function store()
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => 'required|email',
            'customer_id' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
            'role' => 'required',
            'phone' => 'required',
        ]);

        $user = new User();
        $user->name = request('name');
        $user->email = request('email');
        $user->customer_id = request('customer_id');
        $user->role = request('role');
        $user->phone_number = request('phone');
        $user->password = bcrypt(request('password'));
        $user->save();

        return redirect(route('users.index'))->with('success', 'User Account created successfully');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $customers = Customer::all();
        return view('user.edit', compact('user', 'customers'));
    }

    public function update($id)
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => 'required|email',
            'customer_id' => 'required',
            'role' => 'required',
            'phone' => 'required',
        ]);

        $user = User::findOrFail($id);
        $user->name = request('name');
        $user->email = request('email');
        $user->customer_id = request('customer_id');
        $user->role = request('role');
        $user->phone_number = request('phone');
        $user->save();

        return redirect(route('users.index'))->with('success', 'User Account updated successfully');
    }

    public function resetPassword($id)
    {
        $data = request()->validate([
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ]);

        $password = request('password');

        $user = User::findOrFail($id);
        $user->password = bcrypt($password);
        $user->save();

        return redirect(route('users.index'))->with('success', 'User Account password reset successfully');
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect(route('users.index'))->with('success', 'User Account deleted successfully');
    }
}