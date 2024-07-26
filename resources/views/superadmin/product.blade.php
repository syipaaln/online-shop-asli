@extends('layouts.app')

@section('content')
<style>
    .custom-table tbody tr {
      border-bottom: 1px solid #dee2e6; 
    }
    .custom-table thead {
      background-color: #F0F0F0; 
      border-radius: 5px; 
    }
    .custom-table th {
      font-weight: 600; 
    }
</style>
<body style="background-color: #F6F6F6">

<div class="container mt-3 border-radius:5px">
  <form class="search-form w-full mb-5" action="{{ route('superadminSearch') }}" method="GET">
    <input class="form-control bg-white border-0 shadow-sm" type="search" name="query" placeholder="Cari Produk" aria-label="Search">
  </form>
    <div class="row">
        <div class="col-md-12">
            <div>
              @if (Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
              @endif
            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <a href="{{ route('superadminProductCreate') }}" class="btn btn-primary">Create New Product</a>
              </div>
            </div>
            <div class="card border-0 shadow-sm rounded" style="border-radius: 5px;">
                <div class="card-body" style="background-color: white; border-radius: 5px;">
                  <table class="table custom-table table-default">
                    <thead style="border-radius: 5px;">
                      <tr class="table-light">
                        <th scope="col">Gambar Produk</th>
                        <th scope="col">Nama Produk</th>
                        <th scope="col">Harga Produk</th>
                        <th scope="col">Deksripsi Produk</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col" style="width: 10%">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                        <tr>
                            <td>
                                <img src="{{ asset('/storage/products/'.$product->image) }}" class="rounded" style="width: 150px">
                            </td>
                            <td>{{ $product->title }}</td>
                            <td>{{ "Rp " . number_format($product->price,2,',','.') }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->created_at->format('d M Y') }}</td> 
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                      Aksi
                                    </button>
                                    <ul class="dropdown-menu">
                                      <li>
                                        <a class="dropdown-item" href="{{ route('superadminProductEdit', $product->id) }}">Edit</a>
                                      </li>
                                      <li>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda Yakin ?');">
                                          @csrf
                                          @method('DELETE')
                                          <button class="dropdown-item" type="submit">Hapus</button>
                                        </form>
                                      </li>
                                    </ul>
                                  </div>                                  
                            </td>
                        </tr>
                        @empty
                            <div class="alert alert-danger">
                                Data Products belum Tersedia.
                            </div>
                        @endforelse
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
</div> 
</body>
@endsection