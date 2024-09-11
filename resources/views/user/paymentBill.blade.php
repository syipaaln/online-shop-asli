@extends('layouts.user')

@section('content')
<div class="container">
  <div>
      @if(session('success'))
          <div class="alert alert-success">
              {{ session('success') }}
          </div>
      @endif

      <div class="d-flex justify-content-center flex-column align-items-center w-100">
        <div class="bg-success w-50 h-50 p-4 text-white d-flex justify-content-center" style="font-size: 32px;">
            Pembelian Berhasil
        </div>
        <div class="mt-4">
          Total Yang Belum Dibayar : Rp{{ $total_bayar }}
        </div>
        @if ($pembelian->isNotEmpty())
          <a href="{{ route('generateInvoice', $pembelian->last()->created_at) }}">
              <button class="btn btn-success mt-2">Cetak Struk</button>
          </a>
        @endif
        <a href="{{ route('getUserHistory') }}">
          <button class="btn btn-success mt-2">Halaman History</button>
        </a>
      </div>
  </div>
</div>
@endsection