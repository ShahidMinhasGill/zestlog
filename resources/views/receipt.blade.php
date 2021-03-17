<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600;700&display=swap');
        body{
            background-color: #f4f2ea;
            font-family: "Source Sans Pro", sans-serif;
            margin: 0;
        }
        .mb-5{
            margin-bottom: 3rem;
        }
        .receipt-page-wrapper{
            max-width: 1300px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 15px;
            font-size: 14px;
        }
        .receipt-page-wrapper table{
            width: 100%;
        }
        table.receipt-table{
            border-bottom: 1px solid #32322f;
        }
        table.description-table, table.receipt-table {
            position: relative;
        }
        table.receipt-table thead::before,
        .description-table thead::before {
            content: "";
            border-bottom: 1px solid #32322f !important;
            position: absolute;
            left: 0;
            right: 0;
            width: 100%;
            
        }
        table.receipt-table thead::before{
            top: 38px;
        }
        .description-table thead::before{
            top: 52px;
        }
        
        .description-table thead::after {
            bottom: 0;
        }
        .description-table thead::after{
            content: "";
            border-bottom: 3px solid #32322f !important;
            position: absolute;
            left: 0;
            right: 0;
            width: 100%;
        }
        .receipt-page-wrapper table tr td,
        .receipt-page-wrapper table tr th{
            padding: 10px;
            font-size: 12px;
        }
        .receipt-page-wrapper table tr td {
            vertical-align: top;
        }
        .receipt-head-left{
            width: 50%;
            text-align: left;
        }
        .receipt-head-left h1{
            margin-top: 0;
        }
        .receipt-head-right{
            width: 50%;
            text-align: right;
        }
        .receipt-logo{
            max-height: 110px;
        }
        .receipt-table thead th{
            padding-bottom: 12px;
            text-align: left;
        }
        .text-muted {
            color: #6c757d !important;
        }
        small, .small {
            font-size: 80%;
            font-weight: 400;
        }
        .description-table{
            text-align: center;
        }
        .description-table tbody.t-body{
            border-bottom: 4px solid #32322f;
        }
        
        .desc-table-bottom{
            overflow: auto;
        }
        .desc-table-bottom .bottom-left{
            float: left;
            padding: 10px;
            font-weight: 700;
        }
        .desc-table-bottom .bottom-right{
            float: right;
            padding: 10px;
            font-weight: 700;
            min-width: 130px;
            text-align: center;
        }
        
    </style>
</head>
<body>
<div class="page-content">
    <div class="receipt-page-wrapper">
        <table class="mb-4">
            <tr>
                <td class="receipt-head-left">
                    <h1>Receipt</h1>
                    <address>
                        ZESTLOG LTD<br>
                        12963990<br>
                        27 Old Gloucester Street, <br>
                        London,<br>
                        United Kingdom<br>
                        WC1N 3AX<br>
                        support@zestlog.com
                    </address>
                </td>
               <td class="receipt-head-right">
                    <img class="receipt-logo" src="https://www.zestlog.com/assets/images/Chela One 2-1 Final.png" alt="site-logo">
                </td>
            </tr>
        </table>

        <div class="mb-5">
            <table class="receipt-table">
                <thead class="border-bottom">
                <tr>
                    <th>From</th>
                    <th>To</th>
                    <th>Transfer date</th>
                    <th>Earning month</th>
                    <th>Amount</th>
                </tr>
                </thead>

                <tbody class="border-bottom">
                <tr>
                    <td>ZESTLOG LTD</td>
                    <td>
                        {{$bankObj['bank_holder']}}<br>
                        {{$bankObj['account_number']}}<br>
                        {{$bankObj['bic_code']}}
                    </td>
                    <td>
                        {{scheduleDateTimeFormat($payOutHistoryObj['created_at'])}}
                    </td>
                    <td>{{$payOutHistoryObj['earning_month']}}</td>
                    <td> {{$payOutHistoryObj['amount']}} GBP</td>
                </tr>
                </tbody>
            </table>
            <p><small class="text-muted">Receipt id: {{$payOutHistoryObj['transfer_id']}}</small></p>
        </div>

        <h2 class="font-weight-bold">Description</h2>
        <table class="description-table">
                <thead class="border-bottom">
                <tr>
                    <th>Nr.</th>
                    <th>Service</th>
                    <th>Week of<br>
                        Year
                    </th>
                    <th>Week of<br>
                        Program
                    </th>
                    <th> Time</th>
                    <th>Booking ref. no</th>
                    <th>Earning</th>
                </tr>
                </thead>

                <tbody class="t-body">
                @foreach($bookingsData as $key=> $row)
                    @php $row = get_object_vars($row);
                    $key = $key + 1
                    @endphp
                    <tr>
                        <td>{{$key}}</td>
                        <td>{{$row['service_id']}}</td>
                        <td>{{$row['week_of_year']}}</td>
                        <td>{{$row['week_of_program']}}</td>
                        <td>{{$row['time']}}</td>
                        <td>{{$row['reference_number']}}</td>
                        <td>{{roundValue($row['amount'],3)}} GBP</td>
                    </tr>
                @endforeach
                </tbody>
        </table>
        <div class="desc-table-bottom">
            <div class="bottom-left font-weight-bold">Total</div>
            <div class="bottom-right font-weight-bold">{{$payOutHistoryObj['amount']}} GBP</div>
        </div>
       
    </div>
</div>
</body>
</html>