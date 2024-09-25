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
            'customer_id' => 'nullable',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
            'role' => 'required',
            'phone_number' => 'nullable',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'designation' => 'nullable',
        ]);

        if(request()->hasFile('profile_picture')) {
            $file = request()->file('profile_picture');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $newFileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $newFileName);
            $path = 'uploads/' . $newFileName;
        }

        $user = new User();
        $user->name = request('name');
        $user->email = request('email');
        $user->customer_id = request('customer_id');
        $user->role = request('role');
        $user->phone_number = request('phone');
        $user->password = bcrypt(request('password'));
        $user->profile_photo_path = $path ?? null;
        $user->designation = request('designation');
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
            'role' => 'required',
            'phone_number' => 'nullable',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'designation' => 'nullable',
        ]);

        if(request()->hasFile('profile_picture')) {
            $file = request()->file('profile_picture');
            $newFileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $newFileName);
            $path = 'uploads/' . $newFileName;
        }

        $user = User::findOrFail($id);

        if($user->profile_photo_path) {
            unlink(public_path($user->profile_photo_path));
        }

        $user->name = request('name');
        $user->email = request('email');
        $user->customer_id = request('customer_id');
        $user->role = request('role');
        $user->phone_number = request('phone');
        $user->profile_photo_path = $path ?? null;
        $user->designation = request('designation');
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