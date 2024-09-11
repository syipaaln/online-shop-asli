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
            text-align: right;
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
    @if($histories->isNotEmpty())
        @php
            $history = $histories->first();
        @endphp
        <p>No: {{$history->id}}</p>
        <p class="date">Date: {{ \Carbon\Carbon::parse($date)->format('Y-m-d') }}</p>
    @else
        <p>No history available</p>
        <p class="date">Date: {{ \Carbon\Carbon::parse($date)->format('Y-m-d') }}</p>
    @endif
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th class="center-align">Jumlah</th>
                <th class="right-align">Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($histories as $history)
                <tr>
                    <td class="center-align">{{$loop->iteration}}</td>
                    <td>{{ $history->product->title ?? 'Produk tidak ditemukan' }}</td>
                    <td class="center-align">{{ $history->pembelian->quantity ?? 'Data tidak ditemukan' }}</td>
                    <td class="right-align">Rp {{ number_format($history->price, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="dashed-divider"></div>
    <p class="total-price">Total Harga: Rp {{ number_format($totalPrice, 0, ',', '.') }}</p>
    <h4 class="text-center"> TERIMA KASIH </h4>
</body>
</html>