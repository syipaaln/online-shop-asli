<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
</head>
<body>
    <h1>Invoice</h1>
    <p>Date: {{ $date }}</p>

    <table>
        <thead>
            <tr>
                <th>Product ID</th>
                {{-- <th>Quantity</th> --}}
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($histories as $history)
                <tr>
                    <td>{{ $history->product_id }}</td>
                    {{-- <td>{{ $history->checkout->quantity }}</td> --}}
                    <td>{{ $history->price }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p>Total Price: {{ $totalPrice }}</p>
</body>
</html>