@extends('layouts.user')

@section('content')
    <div class="container mt-5">
        <div class="row">
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="d-flex mb-4 justify-content-between">
                <div class="col-md-7 me-2">
                    <div class="fs-4">Kontak Pemesan</div>
                    <div class="card bg-white">
                        <div class="card-body">
                            <table>
                                <tbody>
                                    <tr>
                                        <th scope="row">Nama</th>
                                        <td> : </td>
                                        <td>{{ $users->name }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Nomor HP</th>
                                        <td> : </td>
                                        <td>{{ $users->no_hp }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Alamat</th>
                                        <td> : </td>
                                        <td>{{ $users->alamat }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Kecamatan</th>
                                        <td> : </td>
                                        <td>{{ $users->kecamatan }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Kabupaten</th>
                                        <td> : </td>
                                        <td>{{ $users->kabupaten }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Provinsi</th>
                                        <td> : </td>
                                        <td>{{ $users->provinsi }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Kode POS</th>
                                        <td> : </td>
                                        <td>{{ $users->kode_pos }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="fs-4">Metode Pembayaran</div>
                    <div class="card bg-white">
                        <div class="card-body d-flex">
                            <div class="card me-2">
                                <div class="card-body">
                                    <img src="{{ asset('images/bca.png') }}" alt="BCA">
                                </div>
                            </div>
                            <div class="card me-2">
                                <div class="card-body">
                                    <img src="{{ asset('images/bni.png') }}" alt="BNI">
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <img src="{{ asset('images/bri.png') }}" alt="BRI">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card border-0 rounded">
                    <div class="card-body">
                        <div>
                        Produk
                        </div>
                        <table class="table table-bordered">
                            <tbody>
                                @forelse ($checkoutsWithProducts as $checkout)
                                    <tr>
                                        <td class="text-center">
                                            <img src="{{ asset('/storage/products/'.$checkout->product->image) }}" class="rounded" style="width: 150px">
                                        </td>
                                        <td>{{ $checkout->product->title }}</td>
                                        <td>{{ "Rp " . number_format($checkout->product->price,2,',','.') }}</td>
                                        <td>
                                            {{ $checkout->checkout->quantity }}
                                        </td>
                                    </tr>
                                @empty
                                    <div class="alert alert-danger">
                                        Data Checkout belum Tersedia.
                                    </div>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="w-full d-flex justify-content-end">
                        <div class="d-flex">
                            <div>Total Harga: </div>
                            <div>Rp{{$total}}</div>
                        </div>
                        </div>
                        <form action="{{ route('paymentProcess') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="payment" class="form-label">Pilih Metode Pembayaran:</label>
                            <select name="payment" id="payment" class="form-select">
                                @foreach ($payments as $payment)
                                    <option value="{{ $payment['type'] }}">{{ $payment['type'] }} - {{ $payment['norek'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Proses Pembayaran</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection