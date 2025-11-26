@extends('layouts.dashboard')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Pembayaran</h5>
            <a href="{{ route('pembayaran.create') }}" class="btn btn-light btn-sm">+ Tambah Pembayaran</a>
        </div>

        <div class="card-body">
            {{-- Search --}}
            <form action="{{ route('pembayaran.index') }}" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari kode transaksi..." value="{{ $search }}">
                    <button class="btn btn-outline-primary" type="submit">Cari</button>
                    @if($search)
                    <a href="{{ route('pembayaran.index') }}" class="btn btn-outline-secondary">Reset</a>
                    @endif
                </div>
            </form>

            {{-- Alert sukses --}}
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Kode Transaksi</th>
                            <th>Nama Kategori</th>
                            <th>Tanggal Bayar</th>
                            <th>Metode</th>
                            <th>Jumlah Bayar</th>
                            <th>Kembalian</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pembayarans as $pembayaran)
                        <tr>
                            <td>{{ $loop->iteration + ($pembayarans->currentPage() - 1) * $pembayarans->perPage() }}</td>
                            <td>{{ $pembayaran->transaksi->kode_transaksi ?? '-' }}</td>
                            <td>{{ $pembayaran->transaksi->kategori->nama ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d M Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $pembayaran->metode_pembayaran == 'cash' ? 'success' : ($pembayaran->metode_pembayaran == 'credit' ? 'warning' : 'info') }}">
                                    {{ ucfirst($pembayaran->metode_pembayaran) }}
                                </span>
                            </td>
                            <td>Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($pembayaran->kembalian, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <a href="{{ route('pembayaran.show', $pembayaran->id) }}" class="btn btn-sm btn-info">
                                    Show
                                </a>
                                <a href="{{ route('pembayaran.edit', $pembayaran->id) }}" class="btn btn-sm btn-warning">
                                    Edit
                                </a>
                                <form action="{{ route('pembayaran.destroy', $pembayaran->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Tidak ada data pembayaran</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $pembayarans->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
