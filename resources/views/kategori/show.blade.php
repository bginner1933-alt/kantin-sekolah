
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Detail Produk') }}</span>
                    <a href="{{ route('kategori.index') }}" class="btn btn-sm btn-outline-primary">Kembali</a>
                </div>

                <div class="card-body">
                    @if ($kategori->image)
                        <img src="{{ Storage::url($kategori->image) }}" class="w-100 rounded mb-3" alt="{{ $kategori->nama }}">
                    @else
                        <h4 class="fw-bold">{{ $kategori->nama }}</h4>
                        <p class="mt-2 mb-1">Nama Kategori: <strong>{{ ($kategori->alamat) }}</strong></p>
                        <p class="mt-2">{!! $kategori->deskripsi !!}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
