<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with('produks')->paginate(10);
        return view('transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $produks = Produk::all();
        return view('transaksi.create', compact('produks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pembeli' => 'required|string|max:255',
            'produk' => 'required|array',
            'produk.*' => 'exists:produks,id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $total_harga = 0;

            // Generate kode_transaksi, e.g., TRX + timestamp
            $kode_transaksi = 'TRX' . time();

            // Set tanggal to now
            $tanggal = now();

            $transaksi = Transaksi::create([
                'kode_transaksi' => $kode_transaksi,
                'tanggal' => $tanggal,
                'nama_pembeli' => $request->nama_pembeli,
                'total_harga' => 0, // temporarily 0, update later
            ]);

            $produkData = [];
            foreach ($request->produk as $key => $produk_id) {
                $produk = Produk::findOrFail($produk_id);
                $jumlah = $request->jumlah[$key];
                $subtotal = $produk->harga * $jumlah;
                $total_harga += $subtotal;

                $produkData[$produk_id] = [
                    'jumlah' => $jumlah,
                    'subtotal' => $subtotal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            $transaksi->produks()->attach($produkData);

            $transaksi->total_harga = $total_harga;
            $transaksi->save();

            DB::commit();

            return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Gagal menyimpan transaksi: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $transaksi = Transaksi::with('produks')->findOrFail($id);
        return view('transaksi.show', compact('transaksi'));
    }

    public function edit($id)
    {
        $transaksi = Transaksi::with('produks')->findOrFail($id);
        $produks = Produk::all();
        return view('transaksi.edit', compact('transaksi', 'produks'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pembeli' => 'required|string|max:255',
            'produk' => 'required|array',
            'produk.*' => 'exists:produks,id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $transaksi = Transaksi::findOrFail($id);
            $transaksi->nama_pembeli = $request->nama_pembeli;

            $total_harga = 0;
            $produkData = [];
            foreach ($request->produk as $key => $produk_id) {
                $produk = Produk::findOrFail($produk_id);
                $jumlah = $request->jumlah[$key];
                $subtotal = $produk->harga * $jumlah;
                $total_harga += $subtotal;

                $produkData[$produk_id] = [
                    'jumlah' => $jumlah,
                    'subtotal' => $subtotal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            $transaksi->produks()->sync($produkData);

            $transaksi->total_harga = $total_harga;
            $transaksi->save();

            DB::commit();

            return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Gagal memperbarui transaksi: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->produks()->detach();
        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }

    public function search(Request $request)
    {
        $keyword = $request->get('keyword');
        $transaksis = Transaksi::where('nama_pembeli', 'like', "%$keyword%")
            ->orWhereHas('produks', function ($query) use ($keyword) {
                $query->where('nama_produk', 'like', "%$keyword%");
            })
            ->paginate(10);

        return view('transaksi.index', compact('transaksis'));
    }
}
