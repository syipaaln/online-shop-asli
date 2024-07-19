@extends('layouts.app')

@section('content')
<<<<<<< HEAD
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
<form class="container mt-2">
    <div class="mb-3">
      <input type="text" class="form-control" id="" placeholder="Cari Produk" style="border: none; outline: none; background-color: white;">
    </div>
</form>

<div class="container mt-3 border-radius:5px">
    <div class="row">
        <div class="col-md-12">
            <div>
              @if (Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
              @endif
            </div>
            <div class="card border-0 shadow-sm rounded" style="border-radius: 5px;">
                <div class="card-body" style="background-color: white; border-radius: 5px;">
                  <table class="table custom-table">
                    <thead style="border-radius: 5px;">
                      <tr>
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
=======
<div class="container mt-2">
        <div class="row">
            <div class="col-md-12">
                <div>
                  @if (Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                  @endif
                </div>
                <form class="search-form w-full mb-5" action="{{ route('adminSearch') }}" method="GET">
                    <input class="form-control bg-white border-0 shadow-sm" type="search" name="query" placeholder="Cari Produk" aria-label="Search">
                </form>
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <a href="{{ route('superadminProductCreate') }}" class="btn btn-md btn-success mb-3">ADD PRODUCT</a>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">IMAGE</th>
                                    <th scope="col">TITLE</th>
                                    <th scope="col">PRICE</th>
                                    <th scope="col">STOCK</th>
                                    <th scope="col" style="width: 20%">ACTIONS</th>
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
                                        <td class="text-center">
                                            <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('products.destroy', $product->id) }}" method="POST">
                                                <a href="{{ route('superadminProductEdit', $product->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                                            </form>
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
>>>>>>> c0acd13cec73f70b28b603420bf2a581ab39efab
                </div>
            </div>
        </div>
    </div>
</div> 
</body>
@endsection