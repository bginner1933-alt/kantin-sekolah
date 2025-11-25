<?php
namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{

    public function index()
    {
        $produk = Produk::with('kategori')->latest()->paginate(5);
        return view('produk.index', compact('produk'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('produk.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        //validate form
        $validated = $request->validate([
            'harga'       => 'required',
            'stok'        => 'required|integer',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        $kategori = Kategori::findOrFail($request->kategori_id);

        $produk              = new Produk();
        $produk->nama_produk = $kategori->nama_kategori;
        $produk->harga       = $request->harga;
        $produk->stok        = $request->stok;
        $produk->kategori_id = $request->kategori_id;

        $produk->save();
        return redirect()->route('produk.index');
    }

    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.show', compact('produk'));
    }

    public function edit($id)
    {
        $produk    = Produk::findOrFail($id);
        $kategoris = Kategori::all();
        return view('produk.edit', compact('produk', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama'        => 'required|min:5',
            'harga'       => 'required',
            'stok'        => 'required|integer',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        $produk              = Produk::findOrFail($id);
        $produk->nama_produk = $request->nama;
        $produk->harga       = $request->harga;
        $produk->stok        = $request->stok;
        $produk->kategori_id = $request->kategori_id;

        $produk->save();
        return redirect()->route('produk.index');

    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        // Check if produk has associated transaksis
        if ($produk->transaksis()->count() > 0) {
            return redirect()->route('produk.index')->with('error', 'Tidak dapat menghapus produk karena masih memiliki transaksi terkait.');
        }

        // Storage::disk('public')->delete($produk->image);
        $produk->delete();
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}
