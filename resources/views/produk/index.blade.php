@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div>
                        {{ __('produk') }}
                    </div>
                    <div class="float-end">
                        <a href="{{ route('produk.create') }}" class="btn btn-sm btn-outline-primary">Tambah Data</a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Kategori</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($produk as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->nama_produk }}</td>
                                    <td>{{ $data->harga }}</td>
                                    <td>{{ $data->stok }}</td>
                                    <td>{{ $data->kategori->nama_kategori ?? 'N/A' }}</td>
                                    <td>
                                        <form action="{{ route('produk.destroy', $data->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                        <a href="{{ route('produk.show', $data->id) }}"
                                            class="btn btn-info btn-sm">Show</a> |
                                        <a href="{{ route('produk.edit', $data->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a> |
                                        <button type="submit" onclick="return confirm('Are You Sure ?');"
                                            class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        Data belum tersedia.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {!! $produk->withQueryString()->links('pagination::bootstrap-4') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
