@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Detail Transaksi</h5>
            <a href="{{ route('transaksi.index') }}" class="btn btn-light btn-sm">Kembali</a>
        </div>

        <div class="card-body">

            {{-- Informasi Transaksi --}}
            <h6 class="fw-bold mb-3">Informasi Transaksi</h6>
            <table class="table table-sm table-bordered mb-4">
                <tr>
                    <th>Kode Transaksi</th>
                    <td>{{ $transaksi->kode_transaksi }}</td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td>{{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d M Y H:i') }}</td>
                </tr>
                <tr>
                    <th>Pelanggan</th>
                    <td>{{ $transaksi->pelanggan->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Total Harga</th>
                    <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                </tr>
            </table>

            {{-- Detail Produk --}}
            <h6 class="fw-bold mb-3">Detail Produk</h6>
            <table class="table table-striped table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksi->produks as $prod)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $prod->nama_produk }}</td>
                        <td>Rp {{ number_format($prod->harga, 0, ',', '.') }}</td>
                        <td>{{ $prod->pivot->jumlah }}</td>
                        <td>Rp {{ number_format($prod->pivot->sub_total, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>

                <tfoot class="table-secondary">
                    <tr>
                        <th colspan="4" class="text-end">Total</th>
                        <th>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
