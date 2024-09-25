<?php

namespace App\Services\ReportHandler;

use App\Models\Contract;
use App\Models\Incident;
use App\Models\RequestReport;
use App\Services\ReportHandler\IReportHandler;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportCaseByContract implements IReportHandler
{
    public function process($report)
    {
        // Extract data from database
        $data = $this->extractData($report->contract_id);

        // Generate report
        $reportFile = $this->generateReport($data);

        // Save report file
        $this->saveReport($report, $reportFile);

        // Send email
        $this->sendEmail($report, $reportFile);
    }

    private function extractData($contractId)
    {
        $contract = Contract::find($contractId);
        $incidents = Incident::where('contract_id', $contractId)->get();

        return [
            'contract' => $contract,
            'incidents' => $incidents,
        ];
    }

    private function generateReport($data)
    {
        $pdf = Pdf::loadView('reports.incidents-by-contract', [
            'contracts' => [$data['contract']],
            'incidents' => $data['incidents'],
        ]);

        $pdf->setPaper('A4', 'portrait');

        return $pdf;
    }

    private function saveReport($report, $reportFile)
    {
        // store pdf file to public folder
        if(!is_dir(public_path('reports'))) {
            mkdir(public_path('reports'));
        }

        $filename = Carbon::now()->format('Y-m-d-H-i-s') . '_' . $report->id . '.pdf';
        
        $reportFile->save(public_path('reports/' . $$filename));

        $report->report_file = 'reports/' . $filename;
        $report->status = 'completed';
        $report->save();
    }

    private function sendEmail($report, $reportFile)
    {
        // Send email
        // Mail::to(Auth::user()->email)->send(new ReportGenerated($reportFile));
    }
}

