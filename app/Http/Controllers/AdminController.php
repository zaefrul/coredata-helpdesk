<?php

namespace App\Http\Controllers;

use App\Models\Component;
use App\Models\Setting;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        if(Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to access this page');
        }

        $component_types = Setting::where('field', 'component_type')->get();
        return view('admin.index', compact('component_types'));
    }
    public function components()
    {
        if(Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to access this page');
        }

        $component_types = Setting::where('field', 'component_type')->get();
        return view('admin.component', compact('component_types'));
    }
    public function runMigration()
    {
        if(Auth::user()->role != 'admin') {
            return redirect()->route('admin.index')->with('error', 'You are not authorized to run migration');
        }
        Artisan::call('migrate');
        return redirect()->route('admin.index')->with('success', 'Migration has been run successfully');
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