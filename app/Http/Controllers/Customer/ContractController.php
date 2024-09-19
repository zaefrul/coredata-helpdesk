<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use Illuminate\Support\Facades\Auth;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::where('customer_id', Auth::user()->customer_id)->get();
        return view('customer_view.contract.index', compact('contracts'));
    }

    public function show($id)
    {
        $contract = Contract::find($id);
        return view('contract.show', compact('contract'));
    }
}