<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Incidents by Contract Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid black; padding: 8px; }
        th { background-color: #f2f2f2; }
        .header { margin-bottom: 20px; }
        .logo {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>
<img src="{{ public_path('images/coredata-inline.png') }}" alt="Company Logo" style="width: 150px;"><br/>
<img src="{{ public_path('images/3.png') }}" alt="Company Logo" style="width: auto; height: 40px;">

<div class="header">
    <h1>Incidents by Contract Report</h1>
    <p>Generated On: {{ now()->format('d-m-Y') }}</p>
</div>

@foreach($contracts as $contract)
    <h3>Contract: {{ $contract->contract_name }}</h3>
    <p>Client: {{ $contract->customer->company_name }}</p>
    <p>Contract Period: {{ $contract->start_date->format('d/M/Y') }} to {{ $contract->end_date->format('d/M/Y') }}</p>
    <p>Total Incidents: {{ count($incidents) }}</p>

    <table>
        <thead>
        <tr>
            <th>Incident ID</th>
            <th>Date</th>
            <th>Type</th>
            <th>Status</th>
            <th>Assigned Agent</th>
            <th>Priority</th>
            <th>Resolution Time</th>
        </tr>
        </thead>
        <tbody>
        @foreach($incidents as $incident)
            <tr>
                <td>{{ $incident->incident_number }}</td>
                <td>{{ $incident->created_at }}</td>
                <td>{{ $incident->incident_type }}</td>
                <td>{{ $incident->status }}</td>
                <td>{{ $incident->currentAssignee ? $incident->currentAssignee->name : 'Unasigned' }}</td>
                <td>{{ $incident->priority }}</td>
                <td>{{ $incident->resolved_at }}</td>
            </tr>
        @endforeach
        @if(count($incidents) == 0)
            <tr>
                <td colspan="7">No incidents found for this contract.</td>
            </tr>
        @endif
        </tbody>
    </table>
@endforeach

</body>
</html>
