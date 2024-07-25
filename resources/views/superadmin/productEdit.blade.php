@extends('layouts.app')

@section('content')
<div class="container mt-3 mb-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-header bg-primary text-white">EDIT PRODUCT</div>
                <div class="card-body bg-white">
                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <div>
                                <img src="{{ asset('storage/products/' . $product->image) }}" class="img-fluid rounded" style="width: 150px;" />
                            </div>
                            <label for="image" class="form-label">IMAGE</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">
                            
                            <!-- error message untuk image -->
                            @error('image')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="title" class="form-label">TITLE</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $product->title) }}" placeholder="Masukkan Judul Product">
                            
                            <!-- error message untuk title -->
                            @error('title')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="description" class="form-label">DESCRIPTION</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="5" placeholder="Masukkan Description Product">{{ old('description', $product->description) }}</textarea>
                            
                            <!-- error message untuk description -->
                            @error('description')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="price" class="form-label">PRICE</label>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price', $product->price) }}" placeholder="Masukkan Harga Product">
                                    
                                    <!-- error message untuk price -->
                                    @error('price')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="stock" class="form-label">STOCK</label>
                                    <input type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" value="{{ old('stock', $product->stock) }}" placeholder="Masukkan Stock Product">
                                    
                                    <!-- error message untuk stock -->
                                    @error('stock')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">UPDATE</button>
                        <button type="reset" class="btn btn-warning">RESET</button>
                    </form> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection