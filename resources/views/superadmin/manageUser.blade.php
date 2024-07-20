@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <form class="search-form w-full mb-3" action="{{ route('superadminSearchUser') }}" method="GET">
            <input class="form-control bg-white border-0 shadow-sm" type="search" name="query" placeholder="Cari Nama" aria-label="Search">
        </form>
        <div class="col-md-12">
        <div class="card border-0 shadow-sm rounded">
                    <div class="card-body bg-white">
                        @if (Session::has('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        <a href="{{ route('manageUserCreate') }}" class="btn btn-md btn-success mb-3">ADD USER</a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Nama User</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col">Tanggal Daftar</th>
                                    <th scope="col" style="width: 20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->alamat }}</td>
                                        <td>{{ $user->created_at->format('d M Y') }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                  Aksi
                                                </button>
                                                <ul class="dropdown-menu">
                                                  <li>
                                                    <a class="dropdown-item" href="{{ route('manageUserEdit', $user->id) }}">Edit</a>
                                                  </li>
                                                  <li>
                                                    <form action="{{ route('manageUserDelete', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda Yakin ?');">
                                                      @csrf
                                                      @method('DELETE')
                                                      <button class="dropdown-item" type="submit">Hapus</button>
                                                    </form>
                                                  </li>
                                                </ul>
                                              </div>  
                                    </tr>
                                @empty
                                    <div class="alert alert-danger">
                                        Data Users belum Tersedia.
                                    </div>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection
