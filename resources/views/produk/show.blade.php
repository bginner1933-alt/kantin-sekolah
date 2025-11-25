
@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        Detail Produk
                    </div>
                    <div class="float-end">
                        <a href="{{ route('produk.index') }}" class="btn btn-sm btn-outline-secondary">Kembali</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Nama Produk:</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $produk->nama_produk }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Harga:</strong>
                        </div>
                        <div class="col-md-8">
                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Stok:</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $produk->stok }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Kategori:</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $produk->kategori->nama_kategori ?? 'N/A' }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('produk.edit', $produk->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('produk.destroy', $produk->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
