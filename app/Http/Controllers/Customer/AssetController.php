<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{
    public function index()
    {
        $assets = Asset::whereHas('contract', function($query) {
            $query->where('department_id', Auth::user()->department_id);
        })->with('contract.department')->get();
        return view('customer_view.asset.index', compact('assets'));
    }

    public function show($id)
    {
        $asset = Asset::whereHas('contract', function($query) {
            $query->where('department_id', Auth::user()->department_id);
        })->with('contract.department')->find($id);
        return view('asset.show', compact('asset'));
    }
}