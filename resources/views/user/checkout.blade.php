@extends('layouts.user')

@section('content')
    <div class="container mb-5">
        <div class="row">
            <div class="col-md-12">
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="card rounded" style="border-radius: 25px;">
                    <div class="card-body" style="background-color: #fff; border-radius: 25px;">
                        <table class="table-borderless w-100">
                            <tbody>
                                @php $total = 0; @endphp
                                @forelse ($checkoutsWithProducts as $checkout)
                                    @php 
                                        $subtotal = $checkout->product->price * $checkout->quantity;
                                        $total += $subtotal; 
                                    @endphp
                                    <tr style="border-bottom: 1px solid #ddd;">
                                        <td class="text-left" style="border: none; width: 150px; padding: 20px;">
                                            <img src="{{ asset('/storage/products/'.$checkout->product->image) }}" class="rounded" style="width: 150px; border-radius: 15px;">
                                        </td>
                                        <td style="border: none; padding-right: 20px; padding: 20px;">
                                            <div class="fw-bolder">{{ $checkout->product->title }}</div>
                                            <div class="fw-normal">{{ "Rp " . number_format($checkout->product->price, 2, ',', '.') }}</div>
                                            <div class="fw-light">{{ __("Jumlah") }}</div>
                                            <div style="margin-top: 10px;"> <!-- Menambahkan margin-top di sini -->
                                                <form action="{{ route('checkoutUpdate', $checkout->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="d-flex align-items-center" >
                                                        <div class="quantity-button me-1" onclick="updateQuantity({{ $checkout->id }}, -1)">
                                                            <i class="bi bi-dash-circle"></i>
                                                        </div>
                                                        <input class="quantity-number" id="quantity-{{ $checkout->id }}" name="quantity" type="number" value="{{ $checkout->quantity }}" min="1" readonly 
                                                            style="width: 50px; 
                                                                   margin: 0 5px; 
                                                                   border: none; 
                                                                   outline: none; 
                                                                   background: none; 
                                                                   appearance: none; 
                                                                   padding: 0;" />
                                                        <div class="quantity-button me-1" onclick="updateQuantity({{ $checkout->id }}, 1)">
                                                            <i class="bi bi-plus-circle" ></i>
                                                        </div>
                                                    </div>                                                    
                                                </form>
                                            </div>
                                        </td>
                                        <td class="fw-semibold text-right" style="border: none; width: 100px;">
                                            {{ "Rp " . number_format($subtotal, 2, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center" style="border: none;">No items in checkout</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <nav class="navbar bg-white navbar-expand fixed-bottom">
        <ul class="navbar-nav nav-justified w-100">
            <li class="nav-item col-6 d-flex justify-content-center align-items-center">
                <span>Total Semua: <span class="fw-bold">Rp {{ number_format($total, 2, ',', '.') }}</span></span>
            </li>
            <li class="nav-item col-6 d-flex justify-content-center align-items-center">
                <a href="{{ route('userPayment') }}" class="btn" style="background-color: #6F9CF3; color: #fff;">Lanjut Pembayaran</a>
            </li>
        </ul>
    </nav>

    <script>
    function updateQuantity(id, change) {
        var quantityInput = document.getElementById('quantity-' + id);
        var currentValue = parseInt(quantityInput.value);
        var newValue = currentValue + change;
    
        if (newValue >= 1) {
            quantityInput.value = newValue;
    
            // Mengirim data ke server
            fetch("{{ route('checkoutUpdate', '') }}/" + id, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    _method: 'PUT',
                    quantity: newValue
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }
    }
    </script>
    @endsection

