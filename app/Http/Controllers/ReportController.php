<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Incident;
use App\Models\RequestReport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        // Fetch data for the report (replace with your actual data fetching logic)
        $contracts = Contract::where('id', $request->contract_id)->get();
        $incidents = Incident::where('contract_id', $request->contract_id)->get();

        // Load the Blade template and render it as a PDF
        $pdf = Pdf::loadView('report.template.case_by_contract', [
            'contracts' => $contracts,
            'incidents' => $incidents,
        ]);

        // Return the generated PDF as a download or display
        return $pdf->download('Incidents_by_Contract_Report.pdf');
    }
}