<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sales Report</title>
    <style>
        /* Custom styles */

        .container {
            margin-top: 50px;
        }

        .mb-4 {
            margin-bottom: 1.5rem !important;
        }

        .d-flex {
            display: flex !important;
        }

        .justify-content-between {
            justify-content: space-between !important;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody+tbody {
            border-top: 2px solid #dee2e6;
        }

        .table-dark {
            color: #fff;
            background-color: #212529;
        }

        .table-dark th,
        .table-dark td,
        .table-dark thead th {
            border-color: #32383e;
        }

        .table-hover tbody tr:hover {
            color: #fff;
            background-color: rgba(0, 0, 0, 0.075);
        }

        .table-warning {
            background-color: #ffeeba;
        }

        .table-warning th,
        .table-warning td,
        .table-warning thead th {
            border-color: #ffeeba;
        }

        .text-center {
            text-align: center !important;
        }

        table {
            border-collapse: collapse;
        }
    </style>

</head>

<body>
    <div class="container mt-5">
        <div class="mb-4 d-flex w-100 justify-content-between ">
            <div class="">
                <h2>Sales Report</h2>
                <p>Date start From: <b>{{ $fromDate }} </b>To: <b>{{ $toDate }}</b> </p>
            </div>
            <div class="">
                {{-- <img class="" style="width: 120px" src="{{ asset('images/logo.png') }}" alt="">
                 <p>Lorem ipsum dolor </p> --}}
            </div>
        </div>



        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Mobile</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Total</th>
                    <th scope="col">Discount</th>
                    <th scope="col">Vat</th>
                    <th scope="col">Payable</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice as $invoice)
                    <tr>
                        <th>{{ $loop->iteration }}</th>
                        <td>{{ $invoice['customer']['name'] }}</td>
                        <td>{{ $invoice['customer']['mobile'] }}</td>
                        <td>{{ $invoice['customer']['email'] }}</td>
                        <td>{{ $invoice['total'] }}</td>
                        <td>{{ $invoice['discount'] }}</td>
                        <td>{{ $invoice['vat'] }}</td>
                        <td>{{ $invoice['payable'] }}</td>
                    </tr>
                @endforeach
                <tr class="table-warning">
                    <th class="text-center" colspan="4">Total</th>
                    <th scope="col">{{ $summary[0]['total_sell'] }}</th>
                    <th scope="col">{{ $summary[0]['total_discount'] }}</th>
                    <th scope="col">{{ $summary[0]['total_vat'] }}</th>
                    <th scope="col">{{ $summary[0]['total_payable'] }}</th>
                </tr>
            </tbody>
        </table>
    </div>

    </script>
</body>

</html>
