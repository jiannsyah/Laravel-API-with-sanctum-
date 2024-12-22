<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <table>
        <thead>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Address</th>
                <th>PPn</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer )
                <tr>
                    <td>{{$customer['codeCustomer']}}</td>
                    <td>{{$customer['nameCustomer']}}</td>
                    <td>{{$customer['addressLine1']}}</td>
                    <td>{{$customer['ppn']}}</td>
                    <td>{{$customer['status']}}</td>
                </tr>
            @endforeach
        </tbody>
    
    </table>
</body>
</html>