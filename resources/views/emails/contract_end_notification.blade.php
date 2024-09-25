<!DOCTYPE html>
<html>
<head>
    <title>Contracts Ending Soon</title>
</head>
<body>
    <img src="{{ asset('images/3.png') }}" alt="Logo" width="auto" height="30">

    <h1>Contracts Ending Soon</h1>
    <p>Hello Admin,</p>
    <p>The following contracts are ending soon:</p>
    
    <table>
        <thead>
            <tr>
                <th>Contract Details</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contracts as $contract)
            <tr>
                <td>
                    <p>Customer Name: {{ $contract->customer->company_name }}</p>
                    <p>Contract Name: {{ $contract->contract_name }}</p>
                    <p>Contract Start Date: {{ $contract->start_date->format('d/M/Y') }}</p>
                    <p>Contract End Date: {{ $contract->end_date->format('d/M/Y') }}</p>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <p>Please take necessary action.</p>
    <img src="{{ asset('images/coredata-inline.png') }}" alt="Logo" width="auto" height="30">
</body>
</html>
