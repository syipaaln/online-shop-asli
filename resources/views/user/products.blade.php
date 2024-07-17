@extends('layouts.user')

@section('content')
    <div class="container mt-3">
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
        <div class="d-flex justify-content-between align-items-center mt-5 mb-3">
            <h5 class="fw-bold">PRODUK</h5>
            <form class="search-form w-25" action="{{ route('search') }}" method="GET">
                <input class="form-control bg-white border-0 shadow-sm" type="search" name="query" placeholder="Cari Produk" aria-label="Search">
            </form>
        </div>
        <div class="row mt-3">
            @forelse ($products as $product)
                <div class="col-md-4 col-lg-3 col-xl-2 mb-4">
                    <div class="card product-card h-100 bg-white border-0 shadow-sm">
                        <img src="{{ asset('/storage/products/'.$product->image) }}" class="card-img-top" alt="Product Image">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fs-6 mb-4 text-uppercase">{{ $product->title }}</h5>
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