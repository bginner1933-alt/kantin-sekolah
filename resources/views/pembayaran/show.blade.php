@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h4>Detail Pembayaran</h4>
        </div>
        <div class="card-body">
            {{-- Informasi Pembayaran --}}
            <h5 class="mb-3">Informasi Pembayaran</h5>
            <table class="table table-bordered">
                <tr>
                    <th>ID Pembayaran</th>
                    <td>{{ $pembayaran->id }}</td>
                </tr>
                <tr>
                    <th>Tanggal Pembayaran</th>
                    <td>{{ $pembayaran->tanggal_bayar }}</td>
                </tr>
                <tr>
                    <th>Total Bayar</th>
                    <td>Rp {{ number_format($pembayaran->transaksi->total_harga, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Uang Diterima</th>
                    <td>Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Kembalian</th>
                    <td>Rp {{ number_format($pembayaran->kembalian, 0, ',', '.') }}</td>
                </tr>
            </table>

            {{-- Informasi Transaksi --}}
            <h5 class="mt-4 mb-3">Informasi Transaksi</h5>
            <table class="table table-bordered">
                <tr>
                    <th>Kode Transaksi</th>
                    <td>{{ $pembayaran->transaksi->kode_transaksi }}</td>
                </tr>
                <tr>
                    <th>Tanggal Transaksi</th>
                    <td>{{ $pembayaran->transaksi->tanggal }}</td>
                </tr>
                <tr>
                    <th>Total Transaksi</th>
                    <td>Rp {{ number_format($pembayaran->transaksi->total_harga, 0, ',', '.') }}</td>
                </tr>
            </table>

            {{-- Detail Produk --}}
            <h5 class="mt-4 mb-3">Detail Produk</h5>
            <table class="table table-striped table-bordered">
                <thead class="table-secondary">
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pembayaran->transaksi->produks as $index => $produk)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $produk->nama }}</td>
                        <td>Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                        <td>{{ $produk->pivot->jumlah }}</td>
                        <td>Rp {{ number_format($produk->pivot->sub_total, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Informasi Pelanggan --}}
            <h5 class="mt-4 mb-3">Informasi Pelanggan</h5>
            <table class="table table-bordered">
                <tr>
                    <th>Nama Pelanggan</th>
                    <td>{{ $pembayaran->transaksi->pelanggan->nama }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $pembayaran->transaksi->pelanggan->alamat }}</td>
                </tr>
            </table>

            <div class="mt-3">
                <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
