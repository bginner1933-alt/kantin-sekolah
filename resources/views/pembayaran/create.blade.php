@extends('layouts.dashboard')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Tambah Pembayaran</h5>
            <a href="{{ route('pembayaran.index') }}" class="btn btn-light btn-sm">Kembali</a>
        </div>

        <div class="card-body">
            {{-- Notifikasi Error --}}
            @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('pembayaran.store') }}" method="POST">
                @csrf

                {{-- Search Transaksi --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Cari Kode Transaksi</label>
                    <input type="text" id="searchTransaksi" class="form-control" placeholder="Ketik kode transaksi...">
                    <ul id="searchResult" class="list-group mt-1" style="display: none;"></ul>
                </div>

                {{-- Info Transaksi --}}
                <div id="transaksiInfo" style="display:none;">
                    <input type="hidden" name="id_transaksi" id="id_transaksi">

                    <div class="mb-3">
                        <label class="form-label">Kode Transaksi</label>
                        <input type="text" id="kode_transaksi" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" id="nama_kategori" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Total Harga</label>
                        <input type="text" id="total_harga" class="form-control" readonly>
                    </div>
                </div>

                <hr>

                {{-- Form Pembayaran --}}
                <div class="mb-3">
                    <label class="form-label">Tanggal Bayar</label>
                    <input type="date" name="tanggal_bayar" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Metode Pembayaran</label>
                    <select name="metode_pembayaran" class="form-select" required>
                        <option value="">-- Pilih Metode --</option>
                        <option value="cash">Cash</option>
                        <option value="credit">Credit</option>
                        <option value="debit">Debit</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jumlah Bayar</label>
                    <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-control" min="0" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kembalian</label>
                    <input type="text" name="kembalian" id="kembalian" class="form-control" readonly>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Simpan Pembayaran</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchTransaksi');
        const searchResult = document.getElementById('searchResult');
        const transaksiInfo = document.getElementById('transaksiInfo');
        const totalHargaInput = document.getElementById('total_harga');
        const jumlahBayarInput = document.getElementById('jumlah_bayar');
        const kembalianInput = document.getElementById('kembalian');
        const idTransaksiInput = document.getElementById('id_transaksi');

        // AJAX search transaksi
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            if (query.length < 2) {
                searchResult.style.display = 'none';
                return;
            }

            fetch(`/transaksi/search?query=${query}`)
                .then(res => res.json())
                .then(data => {
                    searchResult.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(item => {
                            const li = document.createElement('li');
                            li.classList.add('list-group-item', 'list-group-item-action');
                            li.textContent = `${item.kode_transaksi} - ${item.kategori.nama} (Rp${parseInt(item.total_harga).toLocaleString('id-ID')})`;
                            li.addEventListener('click', () => {
                                idTransaksiInput.value = item.id;
                                document.getElementById('kode_transaksi').value = item.kode_transaksi;
                                document.getElementById('nama_kategori').value = item.kategori.nama;
                                totalHargaInput.value = 'Rp' + parseInt(item.total_harga).toLocaleString('id-ID');

                                transaksiInfo.style.display = 'block';
                                searchResult.style.display = 'none';
                                searchInput.value = '';
                            });
                            searchResult.appendChild(li);
                        });
                        searchResult.style.display = 'block';
                    } else {
                        searchResult.style.display = 'none';
                    }
                })
                .catch(() => {
                    searchResult.style.display = 'none';
                });
        });

        // Hitung kembalian otomatis
        jumlahBayarInput.addEventListener('input', function() {
            const total = parseInt(totalHargaInput.value.replace(/[^0-9]/g, '')) || 0;
            const bayar = parseInt(this.value) || 0;
            let kembali = bayar - total;
            if (kembali < 0) kembali = 0;
            kembalianInput.value = 'Rp' + kembali.toLocaleString('id-ID');
        });

        // Validasi sebelum submit
        document.querySelector('form').addEventListener('submit', function(e) {
            if (!idTransaksiInput.value) {
                e.preventDefault();
                alert('Silakan pilih transaksi terlebih dahulu!');
            }
        });
    });

</script>
@endsection
