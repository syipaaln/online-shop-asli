@extends('layouts.user')

@section('content')
    <div class="container">
        <h1>History Pembelian</h1>

        @if($groupedHistories->isEmpty())
            <p>No history found for this user.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Products</th>
                        <th>Total Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($groupedHistories as $group)
                        <tr>
                            <td>{{ $group['date'] }}</td>
                            <td>
                                <ul>
                                    @foreach($group['products'] as $product)
                                        <li>Product ID: {{ $product->product_id }}, Price: {{ $product->price }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>{{ $group['total_price'] }}</td>
                            <td>
                                <form action="{{ route('generateInvoice', ['date' => $group['date']]) }}" method="GET">
                                    @csrf
                                    <button type="submit">Cetak Invoice</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
