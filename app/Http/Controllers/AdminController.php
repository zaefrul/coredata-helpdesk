<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function runMigration()
    {
        if(Auth::user()->role != 'admin') {
            return redirect()->route('admin.index')->with('error', 'You are not authorized to run migration');
        }
        Artisan::call('migrate');
        return redirect()->route('dashboard')->with('success', 'Migration has been run successfully');
    }

    public function runSeeder()
    {
        if(Auth::user()->role != 'admin') {
            return redirect()->route('admin.index')->with('error', 'You are not authorized to run seeder');
        }
        Artisan::call('db:seed');
        return redirect()->route('dashboard')->with('success', 'Seeder has been run successfully');
    }
}