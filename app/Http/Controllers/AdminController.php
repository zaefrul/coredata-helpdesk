<?php

namespace App\Http\Controllers;

use App\Helper\AssetHelper;
use App\Imports\AssetsImport;
use App\Models\Component;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

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
        try
        {
            Artisan::call('migrate');
            return redirect()->route('admin.index')->with('success', 'Migration has been run successfully');
        }
        catch(\Exception $e)
        {
            return redirect()->route('admin.index')->with('error', 'Migration failed: ' . $e->getMessage());
        }
    }

    public function runSeeder()
    {
        if(Auth::user()->role != 'admin') {
            return redirect()->route('admin.index')->with('error', 'You are not authorized to run seeder');
        }
        try
        {
            Artisan::call('db:seed');
            return redirect()->route('dashboard')->with('success', 'Seeder has been run successfully');
        }
        catch(\Exception $e)
        {
            return redirect()->route('dashboard')->with('error', 'Seeder failed: ' . $e->getMessage());
        }
        
    }

    public function importAssets(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|integer',
            'department_id' => 'required|integer',
            'csv_file' => 'required|file|mimes:xlsx',
        ]);

        $customerId = $request->customer_id;
        $departmentId = $request->department_id;

        Excel::import(new AssetsImport($customerId, $departmentId), $request->file('csv_file'));

        return back()->with('success', 'Assets imported successfully.');
    }

}