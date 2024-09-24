<?php

namespace App\Http\Controllers\Public;

use App\Helper\IncidentLogic;
use App\Models\Asset;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Incident;
use App\Models\IncidentAuditLog;

class AssetViewController extends Controller
{
    public function show($id)
    {
        $asset = Asset::findOrFail($id);
        $scheduleTasks = Incident::where('asset_id', $id)->where('incident_number', 'like', "%-ST")->get();
        $replaceComponentLogs = $this->getReplaceComponentLogs($id);
        // get activity logs about part replacement for current asset.

        return view('public.asset_detail', compact('asset', 'scheduleTasks', 'replaceComponentLogs'));
    }

    private function getReplaceComponentLogs($asset_id)
    {
        // get all incidents where the asset was replaced
        $incidents = Incident::where('asset_id', $asset_id)->get();
        $auditLogs = ActivityLog::whereIn('incident_id', $incidents->pluck('id')->toArray())
            ->where('description', 'like', '%Component Replaced%')
            ->get();
        
        if(!$auditLogs) {
            return Array();
        }
        
        $auditLogs = IncidentLogic::processActivityLogsDescription($auditLogs);

        return $auditLogs;
    }
}