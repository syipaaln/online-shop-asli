@extends('layouts.user')

@section('content')
    <div class="container">
        <div class="row">
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="col-md-12">
                <form id="paymentForm" action="{{ route('paymentProcess') }}" method="POST">
                    @csrf
                    <div class="d-flex mb-4 justify-content-between">
                        <div class="col-md-7 me-3">
                            <div class="fs-4">Kontak Pemesan</div>
                            <div class="card border-0 bg-white">
                                <div class="card-body">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <th scope="row">Nama</th>
                                                <td>:</td>
                                                <td>{{ $users->name }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Nomor HP</th>
                                                <td>:</td>
                                                <td>{{ $users->no_hp }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Alamat</th>
                                                <td>:</td>
                                                <td>{{ $users->alamat }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Kecamatan</th>
                                                <td>:</td>
                                                <td>{{ $users->kecamatan }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Kabupaten</th>
                                                <td>:</td>
                                                <td>{{ $users->kabupaten }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Provinsi</th>
                                                <td>:</td>
                                                <td>{{ $users->provinsi }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Kode POS</th>
                                                <td>:</td>
                                                <td>{{ $users->kode_pos }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="fs-4">Metode Pembayaran</div>
                            <div class="card border-0 bg-white">
                                <div class="card-body">
                                        <div class="d-flex justify-content-around">
                                            @foreach ($payments as $payment)
                                                <label class="payment-option form-check-label text-center" style="cursor: pointer; width: 100px;">
                                                    <input type="radio" name="payment" class="d-none" value="{{ $payment['type'] }}">
                                                    <div class="bg-light rounded p-4">
                                                        <img src="{{ asset('images/' . strtolower($payment['type']) . '.png') }}" alt="{{ $payment['type'] }}" class="img-fluid" style="max-width: 100%;">
                                                    </div>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fs-4">Produk Dipesan</div>
                        <div class="card border-0 bg-white rounded">
                            <div class="card-body">
                                @forelse ($checkoutsWithProducts as $checkout)
                                <div class="d-flex mb-3">
                                    <div>
                                        <img src="{{ asset('/storage/products/'.$checkout->product->image) }}" class="rounded" style="width: 150px;">
                                    </div>
                                    <div class="ms-3 flex-grow-1">
                                        <div class="fw-bold fs-5">{{ $checkout->product->title }}</div>
                                        <div>{{ "Rp " . number_format($checkout->product->price, 2, ',', '.') }}</div>
                                        <div class="fw-light">Jumlah</div>
                                        <div class="fw-light">{{ $checkout->checkout->quantity }}</div>
                                    </div>
                                    <div class="mt-2 ms-auto d-flex align-items-center fw-bold">Rp{{ number_format($checkout->subtotal, 2, ',', '.') }}</div>
                                </div>
                                <hr class="border-2">
                                @empty
                                <div class="alert alert-danger">
                                    Data Checkout belum Tersedia.
                                </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="card border-0 bg-white my-3 rounded">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                <div>Ongkos Kirim</div>
                                <div class="fw-bold">Rp 20.000</div>
                            </div>
                        </div>
                    </div>
                    <div class="card border-0 bg-white my-3 rounded">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex">
                                    <div>Total Semua: </div>
                                    <div class="fw-bold">Rp{{ number_format($total, 2, ',', '.') }}</div>
                                </div>
                                <button type="submit" class="btn btn-primary w-20">Bayar Sekarang</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .payment-option {
            border: 2px solid transparent;
            cursor: pointer;
        }
        .payment-option input:checked + div {
            border-color: #007bff;
            border-width: 2px;
            border-style: solid;
        }
        .payment-option:hover {
            border-color: #007bff;
            border-radius: 8px;
        }
    </style>
@endsection