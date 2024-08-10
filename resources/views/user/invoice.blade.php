<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            max-height: 80px;
            width: auto;
        }
        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        p {
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            padding: 8px;
            text-align: center;
            border: 1px solid rgb(91, 91, 91);
        }
        td {
            padding: 8px;
            text-align: left;
            border: none;
        }
        .right-align {
            text-align: right;
        }
        .center-align {
            text-align: center;
        }
        .total-price {
            text-align: right;
            margin-top: 20px;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
            margin-top: 20px; 
            font-size: 18px;
        }
        .date{
            text-align: right;
        }
        .dashed-divider {
            border-top: dashed black; 
            width: fit-content;
            margin: 10px auto 20px auto;

        }
    </style>
</head>
<body>
    <div class="logo">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logo.png'))) }}" alt="Logo">
    </div>
    <p class="date">Date: {{ $date }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Product ID</th>
                {{-- <th class="center-align">Quantity</th> --}}
                <th class="right-align">Total Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($histories as $history)
                <tr>
                    <td class="center-align">{{$history->id}}</td>
                    <td>{{ $history->product_id }}</td>
                    {{-- <td class="center-align">{{ $history->quantity }}</td> --}}
                    <td class="right-align">{{ number_format($history->price, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="dashed-divider"></div>
    <p class="total-price">Total Price: {{ number_format($totalPrice, 0, ',', '.') }}</p>
    <h4 class="text-center"> THANK YOU FOR YOUR VISIT </h4>
</body>
</html>
