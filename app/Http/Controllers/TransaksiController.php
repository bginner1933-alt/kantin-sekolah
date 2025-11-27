<?php
namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\Pembayaran;


class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with(['kategori', 'produks'])->latest()->get();
        return view('transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        $produk    = Produk::all();
        return view('transaksi.create', compact('kategori', 'produk'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_kategori' => 'required|exists:kategoris,id',
            'id_produk'    => 'required|array',
            'id_produk.*'  => 'exists:produks,id',
            'jumlah'       => 'required|array',
            'jumlah.*'     => 'integer|min:1',
        ]);

        // Buat transaksi utama dulu
        $kode                      = 'TRX-' . strtoupper(uniqid());
        $transaksi                 = new Transaksi();
        $transaksi->kode_transaksi = $kode;
        $transaksi->id_kategori   = $request->id_kategori;
        $transaksi->tanggal        = now();
        $transaksi->total_harga    = 0;
        $transaksi->save();

        $totalHarga  = 0;
        $produkPivot = [];

        foreach ($request->id_produk as $index => $produkId) {
            $produk   = Produk::findOrFail($produkId);
            $jumlah   = $request->jumlah[$index];
            $subTotal = $produk->harga * $jumlah;

            // isi array untuk attach pivot
            $produkPivot[$produkId] = [
                'jumlah'    => $jumlah,
                'sub_total' => $subTotal,
            ];

            // kurangi stok
            $produk->stok -= $jumlah;
            $produk->save();

            $totalHarga += $subTotal;
        }

        // simpan relasi produk ke transaksi (many-to-many)
        $transaksi->produks()->attach($produkPivot);

        // update total harga transaksi
        $transaksi->update(['total_harga' => $totalHarga]);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil disimpan!');
    }

    public function show($id)
    {
        $transaksi = Transaksi::with(['kategori', 'produks'])->findOrFail($id);
        return view('transaksi.show', compact('transaksi'));
    }

    public function edit($id)
    {
        $transaksi = Transaksi::with('produks')->findOrFail($id);
        $kategori = Kategori::all();
        $produk    = Produk::all();

        return view('transaksi.edit', compact('transaksi', 'kategori', 'produk'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'id_kategori' => 'required|exists:kategoris,id',
            'id_produk'    => 'required|array',
            'id_produk.*'  => 'exists:produks,id',
            'jumlah'       => 'required|array',
            'jumlah.*'     => 'integer|min:1',
        ]);

        $transaksi = Transaksi::with('produks')->findOrFail($id);

        // Kembalikan stok produk lama
        foreach ($transaksi->produks as $oldProduk) {
            $p = Produk::find($oldProduk->id);
            if ($p) {
                $p->stok += $oldProduk->pivot->jumlah;
                $p->save();
            }
        }

        // kosongkan pivot lama
        $transaksi->produks()->detach();

        // update data transaksi
        $transaksi->id_kategori = $request->id_kategori;
        $transaksi->tanggal      = now();
        $transaksi->total_harga  = 0;
        $transaksi->save();

        $totalHarga  = 0;
        $produkPivot = [];

        foreach ($request->id_produk as $index => $produkId) {
            $produk   = Produk::findOrFail($produkId);
            $jumlah   = $request->jumlah[$index];
            $subTotal = $produk->harga * $jumlah;

            $produkPivot[$produkId] = [
                'jumlah'    => $jumlah,
                'sub_total' => $subTotal,
            ];

            // kurangi stok baru
            $produk->stok -= $jumlah;
            $produk->save();

            $totalHarga += $subTotal;
        }

        // simpan relasi pivot baru
        $transaksi->produks()->attach($produkPivot);

        // update total harga
        $transaksi->update(['total_harga' => $totalHarga]);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy($id)
{
    // Temukan transaksi dengan data terkait
    $transaksi = Transaksi::with('produks')->findOrFail($id);

    // Cek jika ada record Pembayaran terkait
    $pembayaran = Pembayaran::where('id_transaksi', $transaksi->id)->first();

    // Jika ada, hapus record Pembayaran tersebut
    if ($pembayaran) {
        $pembayaran->delete();
    }

    // Kembalikan stok produk yang terkait dengan transaksi
    foreach ($transaksi->produks as $produk) {
        $p = Produk::find($produk->id);
        if ($p) {
            $p->stok += $produk->pivot->jumlah;
            $p->save();
        }
    }

    // Hapus relasi produk dari transaksi
    $transaksi->produks()->detach();

    // Hapus transaksi utama
    $transaksi->delete();

    return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus dan stok dikembalikan!');
}


    public function search(Request $request)
    {
        $query     = $request->query('query');
        $transaksi = Transaksi::with('kategori')
            ->where('kode_transaksi', 'like', "%$query%")
            ->get();

        return response()->json($transaksi);
    }

}
