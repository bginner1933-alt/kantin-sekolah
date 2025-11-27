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
                        <p class="mt-2 mb-1">Nama Kategori: <strong>{{ ($kategori->nama) }}</strong></p>
                        <p class="mt-2">{!! $kategori->deskripsi !!}</p>
                    @endif
                    @if ($kategori->image)
                        <img src="{{ Storage::url($kategori->image) }}" class="w-100 rounded mb-3" alt="{{ $kategori->nama }}">
                    @else
                        <p class="mt-2 mb-1">Nama Alamat: <strong>{{ ($kategori->alamat) }}</strong></p>
                        <p class="mt-2">{!! $kategori->deskripsi !!}</p>
                    @endif
                    @if ($kategori->image)
                        <img src="{{ Storage::url($kategori->image) }}" class="w-100 rounded mb-3" alt="{{ $kategori->nama }}">
                    @else
                        <p class="mt-2 mb-1">No Telepon: <strong>{{ ($kategori->no_telepon) }}</strong></p>
                        <p class="mt-2">{!! $kategori->deskripsi !!}</p>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
