<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Replacement Parts Report</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            margin: 20px;
            color: #333;
        }
        .header, .asset-header {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #ddd;
        }
        .header h3 {
            margin: 0;
            color: #2c3e50;
        }
        .logo-container {
        }
        .logo {
            width: 150px;
        }
        .report-details {
            font-size: 14px;
            margin-top: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 13px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            color: #34495e;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .no-data {
            text-align: center;
            font-style: italic;
            color: #888;
        }
        hr {
            border: none;
            border-top: 1px solid #ddd;
            margin: 40px 0;
        }
        .asset-header h4 {
            color: #2980b9;
            margin-bottom: 5px;
        }
        .asset-details {
            font-size: 14px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <img src="{{ public_path('images/coredata-inline.png') }}" alt="Company Logo" class="logo"><br />
    <img src="{{ public_path('images/3.png') }}" alt="Company Logo" class="logo" style="height: 40px; width: auto;">

<div class="header" style="margin-top: 3rem;">
    <h3>Replacement Parts Report</h3>
    <div class="report-details">
        <p><strong>Contract:</strong> {{ $contract->contract_name }}</p>
        <p><strong>Client:</strong> {{ $contract->customer->company_name }}</p>
        <p><strong>Contract Period:</strong> {{ $contract->start_date->format('d/M/Y') }} to {{ $contract->end_date->format('d/M/Y') }}</p>
        <p><strong>Generated On:</strong> {{ now()->format('d-m-Y') }}</p>
    </div>
</div>

@foreach($assets as $asset)
    <div class="asset-header">
        <h4>Asset: {{ $asset->name }}</h4>
        <div class="asset-details">
            <p><strong>Asset Number:</strong> {{ ucfirst($asset->asset_number) }}</p>
            <p><strong>Category:</strong> {{ ucfirst($asset->category) }}</p>
            <p><strong>Location:</strong> {{ $asset->location ?? "-" }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Component Type</th>
                <th>Original Part</th>
                <th>Replacement Part</th>
                <th>Replacement Date</th>
            </tr>
        </thead>
        <tbody>
            @php
                $partsReplacements = array_filter($componentReplacementLogs, function($log) use ($asset) {
                    return $log['asset_id'] == $asset->id;
                });
                // $partsReplacements = $componentReplacementLogs->where('asset_id', $asset->id);
            @endphp
            @foreach($partsReplacements as $part)
                <tr>
                    <td>{{ strtoupper(\App\Helper\SettingHelper::getLabelValue('component_type', $part['old_item']->type)) }}</td>
                    <td>
                        <p>{{ $part['old_item']->model }}</p>
                        <p><strong>S/N</strong> : {{ $part['old_item']->serial_number }}</p>
                        <p><strong>P/N</strong> : {{ $part['old_item']->part_number }}</p>
                    </td>
                    <td>
                        <p>{{ $part['new_item']->model }}</p>
                        <p><strong>S/N</strong> : {{ $part['new_item']->serial_number }}</p>
                        <p><strong>P/N</strong> : {{ $part['new_item']->part_number }}</p>
                    </td>
                    <td>{{ $part['created_at']->format('d/M/Y') }}</td>
                </tr>
            @endforeach
            @if(count($partsReplacements) == 0)
                <tr>
                    <td colspan="4" class="no-data">No replacement parts found for this asset.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <hr />
@endforeach

</body>
</html>
