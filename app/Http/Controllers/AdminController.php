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
        return redirect()->route('admin.index')->with('success', 'Migration has been run successfully');
    }
}