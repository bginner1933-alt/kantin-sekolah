@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Detail Produk') }}</span>
                    <a href="{{ route('produk.index') }}" class="btn btn-sm btn-outline-primary">Kembali</a>
                </div>

                <div class="card-body">
                    @if ($produk->image)
                    <img src="{{ Storage::url($produk->image)  }}" class="w-100 rounded mb-3" alt="{{ $produk->nama }}">
                    @else
                    @endif

                    <h4 class="fw-bold">{{ $produk->nama }}</h4>
                    <p class="mt-2 mb-1">Harga: <strong>Rp{{ number_format($produk->harga, 0, ',', '.') }}</strong></p>
                    <p class="mt-2">{!! $produk->deskripsi !!}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
