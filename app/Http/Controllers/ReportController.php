<?php

namespace App\Http\Controllers;

use App\Helper\IncidentLogic;
use App\Models\ActivityLog;
use App\Models\Asset;
use App\Models\Contract;
use App\Models\Incident;
use App\Models\Inventory;
use App\Models\RequestReport;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    public function index()
    {
        $requestReport = RequestReport::where('request_by', Auth::user()->id)->orderby('created_at', 'desc')->get();
        $contracts = Contract::select(['id', 'contract_name'])->get();
        return view('report.index', compact('requestReport', 'contracts'));
    }

    public function case_by_contract(Request $request)
    {
        $request->validate([
            'contract_id' => 'required|integer',
        ]);

        RequestReport::create([
            'contract_id' => $request->contract_id,
            'report_type' => RequestReport::CASE_BY_CONTRACT,
            'request_by' => Auth::user()->id,
        ]);

        return redirect()->route('report.index')->with('success', 'Report requested successfully. Please wait for the email.');
    }

    public function case_by_contract_download(Request $request)
    {
        $request->validate([
            'contract_id' => 'required|integer|exists:contracts,id',
        ]);

        // Fetch data for the report (replace with your actual data fetching logic)
        $contracts = Contract::where('id', $request->contract_id)->get();
        $incidents = Incident::where('contract_id', $request->contract_id)->get();

        // Load the Blade template and render it as a PDF
        $pdf = Pdf::loadView('report.template.case_by_contract', [
            'contracts' => $contracts,
            'incidents' => $incidents,
        ]);

        $filename = 'Incidents_by_Contract_Report' . Carbon::now()->format('YmdHis') . '.pdf';

        // Return the generated PDF as a download or display
        return $pdf->download($filename);
    }

    public function contract_replacement_parts(Request $request)
    {
        $request->validate([
            'contract_id' => 'required|integer|exists:contracts,id',
        ]);

        if (Auth::user()->role != 'admin') {
            return redirect()->route('report.index')->with('error', 'You are not authorized to request this report.');
        }

        RequestReport::create([
            'contract_id' => $request->contract_id,
            'report_type' => RequestReport::CONTRACT_REPLACEMENT_PARTS,
            'request_by' => Auth::user()->id,
        ]);

        return redirect()->route('report.index')->with('success', 'Report requested successfully. Please wait for the email.');
    }

    public function contract_replacement_parts_download(Request $request)
    {
        $request->validate([
            'contract_id' => 'required|integer|exists:contracts,id',
        ]);

        // Fetch all assets for the contract
        $contract = Contract::find($request->contract_id);
        $assets = Asset::where('contract_id', $request->contract_id)->get();
        $assetsIds = $assets->pluck('id')->toArray();

        $inventories = Inventory::withoutGlobalScope('withoutReplacement')->whereIn('replaced_asset_id', $assetsIds)->get();
        Log::debug(print_r($inventories, true));

        // Load the Blade template and render it as a PDF
        $pdf = Pdf::loadView('report.template.contract_replacement_parts', [
            'contract' => $contract,
            'assets' => $assets,
            'inventories' => $inventories,
        ]);

        $filename = 'Contract_Replacement_Parts_Report' . Carbon::now()->format('YmdHis') . '.pdf';

        // Return the generated PDF as a download or display
        return $pdf->download($filename);
    }
}