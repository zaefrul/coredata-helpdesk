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
                <th>Customer</th>
                <th>Contract Name</th>
                <th>End Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contracts as $contract)
            <tr>
                <td>{{ $contract->customer->company_name }}</td>
                <td>{{ $contract->name }}</td>
                <td>{{ $contract->end_date }}</td>
                <td>
                    <a href="{{ url('contracts/' . $contract->id . '/show') }}">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <p>Please take necessary action.</p>
    <img src="{{ asset('images/coredata-inline.png') }}" alt="Logo" width="auto" height="30">
</body>
</html>
