<?php
namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori; // Jangan lupa import model Kategori
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    // Di Controller ProdukController.php
public function index()
{
    $produk = Produk::latest()->paginate(10);  // Menggunakan paginate() bukan all()
    return view('produk.index', compact('produk'));
}


    public function create()
    {
        // Ambil data kategori dari model Kategori
        $kategoris = Kategori::all();

        // Kirim data kategori ke view produk.create
        return view('produk.create', compact('kategoris'));
    }

    public function store(Request $request)
{
    // Validasi form
    $validated = $request->validate([
        'nama_produk' => 'required|min:5',
        'harga'       => 'required',
        'stok'        => 'required',
        'kategori_id' => 'required|exists:kategoris,id', // Pastikan kategori_id ada di tabel kategoris
    ]);

    // Simpan data produk
    $produk              = new Produk();
    $produk->nama_produk = $request->nama_produk;
    $produk->harga       = $request->harga;
    $produk->stok        = $request->stok;
    $produk->kategori_id = $request->kategori_id; // Simpan kategori_id ke database

    // Simpan produk ke database
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
        $produk = Produk::findOrFail($id);
        $kategoris = Kategori::all(); // Ambil data kategori untuk form edit
        return view('produk.edit', compact('produk', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|min:5',
            'harga'       => 'required',
            'stok'        => 'required',
            'kategori_id' => 'required|exists:kategoris,id', // Pastikan kategori_id ada di tabel kategoris
        ]);

        $produk              = Produk::findOrFail($id);
        $produk->nama_produk = $request->nama_produk;
        $produk->harga       = $request->harga;
        $produk->stok        = $request->stok;
        $produk->kategori_id = $request->kategori_id; // Update kategori_id

        // Simpan perubahan produk ke database
        $produk->save();
        return redirect()->route('produk.index');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();
        return redirect()->route('produk.index');
    }
}
