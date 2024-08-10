@extends('layouts.user')

@section('content')

<style>
    .button-container {
            display: flex;
            justify-content: center;
        }
    button {
        background-color: #5dc761;
        color: white; 
        border: none; 
        padding: 10px 20px; 
        text-align: center; 
        display: inline-block;
        font-size: 12px;
        border-radius: 5px; 
        cursor: pointer; 
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); 
    }
    button:hover {
        background-color: #62be66; 
    }

    button:focus {
        outline: none;
    }
</style>
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
                                <div class="button-container">
                                    <button onclick="window.location.href='{{ route('generateInvoice', ['date' => $group['date']]) }}'">
                                        Cetak Invoice
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
