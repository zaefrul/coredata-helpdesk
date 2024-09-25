<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contracts Ending Soon</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333333;
        }
        p {
            color: #555555;
            line-height: 1.6;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #dddddd;
        }
        th {
            background-color: #f2f2f2;
            color: #333333;
        }
        td {
            background-color: #ffffff;
        }
        img {
            display: block;
            margin: 0 auto;
        }
        footer {
            margin-top: 20px;
            text-align: center;
            color: #777777;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
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
                        <p><strong>Customer Name:</strong> {{ $contract->customer->company_name }}</p>
                        <p><strong>Contract Name:</strong> {{ $contract->contract_name }}</p>
                        <p><strong>Contract Start Date:</strong> {{ $contract->start_date->format('d/M/Y') }}</p>
                        <p><strong>Contract End Date:</strong> {{ $contract->end_date->format('d/M/Y') }}</p>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <p>Please take necessary action.</p>
        
        <img src="{{ asset('images/coredata-inline.png') }}" alt="Logo" width="auto" height="30">
    </div>
    
    <footer>
        &copy; {{ date('Y') }} COREDATA SDN BHD. All rights reserved.
    </footer>
</body>
</html>
