@extends('layouts.user')

@section('content')
    {{-- <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div>
                  @if (Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                  @endif
                </div>

                <div class="row">
                @forelse ($products as $product)
                  <div class="col-4 col-md-3">
                    <div class="card" style="width: 100%;">

                    <img class="card-img-top" src="{{ asset('/storage/products/'.$product->image) }}" alt="Card image cap">
                      <div class="card-body">
                        <h5 class="card-title">{{ $product->title }}</h5>
                        <p class="card-text">{{ "Rp " . number_format($product->price,2,',','.') }}</p>
                        <div class="w-100 d-flex justify-content-center">
                        <form action="{{ route('addToCheckout', $product->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="btn btn-primary">Tambahkan ke Keranjang</button>
                        </form>
                        </div>
                      </div>
                    </div>
                  </div>
                  @empty
                  <div class="alert alert-danger col-12">
                      Data Products belum Tersedia.
                  </div>
                @endforelse
                </div>
                <!-- <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">IMAGE</th>
                                    <th scope="col">TITLE</th>
                                    <th scope="col">PRICE</th>
                                    <th scope="col">STOCK</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                    <tr>
                                        <td class="text-center">
                                            <img src="{{ asset('/storage/products/'.$product->image) }}" class="rounded" style="width: 150px">
                                        </td>
                                        <td>{{ $product->title }}</td>
                                        <td>{{ "Rp " . number_format($product->price,2,',','.') }}</td>
                                        <td>{{ $product->stock }}</td>
                                    </tr>
                                @empty
                                    <div class="alert alert-danger">
                                        Data Products belum Tersedia.
                                    </div>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div> -->
            </div>
        </div>
    </div> --}}

    <div class="container mt-5">
        <div>
            @if (Session::has('success'))
              <div class="alert alert-success">
                  {{ Session::get('success') }}
              </div>
            @endif
        </div>
        <div class="card border-0 shadow-sm rounded text-center bg-white py-5 mb-2">
            <div class="card-body">
                ini banner
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center my-5">
            <h5>PRODUK</h5>
            <form class="search-form" style="max-width: 200px;">
                <input class="form-control bg-white" type="search" placeholder="Cari Produk" aria-label="Search">
            </form>
        </div>
        <div class="row mt-3">
            @forelse ($products as $product)
                <div class="col-md-4 col-lg-3 col-xl-2 mb-4">
                    <div class="card product-card h-100 bg-white">
                        <img src="{{ asset('/storage/products/'.$product->image) }}" class="card-img-top" alt="Product Image">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fs-6 mb-4">{{ $product->title }}</h5>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="card-text fw-bold mb-0">{{ "Rp " . number_format($product->price,2,',','.') }}</p>
                                    <form action="{{ route('addToCheckout', $product->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="submit" class="btn btn-primary btn-sm d-flex align-items-center"><i class="bi bi-cart-plus"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-danger">
                    Data Products belum Tersedia.
                </div>
            @endforelse
        </div>
    </div>
@endsection