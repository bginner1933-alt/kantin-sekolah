<?php
namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{

    public function index()
    {
        $produk = Produk::latest()->paginate(5);
        return view('produk.index', compact('produk'));
    }

    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
        //validate form
        $validated = $request->validate([
            'nama_produk' => 'required|min:5',
            'harga'       => 'required',
            'stok'        => 'required|',
        ]);

        $produk              = new Produk();
        $produk->nama_produk = $request->nama_produk;
        $produk->harga       = $request->harga;
        $produk->stok        = $request->stok;
        // upload image
        // if ($request->hasFile('image')) {
        //     $file       = $request->file('image');
        //     $randomName = Str::random(20) . '.' . $file->getClientOriginalExtension();
        //     $path       = $file->storeAs('produks', $randomName, 'public');
        //     // memasukan nama_produk image nya ke database
        //     $produk->image = $path;
        // }

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
        return view('produk.edit', compact('produk'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|min:5',
            'harga'       => 'required',
            'stok'        => 'required|',
        ]);

        $produk              = Produk::findOrFail($id);
        $produk->nama_produk = $request->nama_produk;
        $produk->harga       = $request->harga;
        $produk->stok        = $request->stok;
        // if ($request->hasFile('image')) {
        //     // menghapus foto lama
        //     Storage::disk('public')->delete($produk->image);

        //     // upload foto baru
        //     $file       = $request->file('image');
        //     $randomName = Str::random(20) . '.' . $file->getClientOriginalExtension();
        //     $path       = $file->storeAs('produks', $randomName, 'public');
        //     // memasukan nama_produk image nya ke database
        //     $produk->image = $path;
        // }
        $produk->save();
        return redirect()->route('produk.index');

    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        // Storage::disk('public')->delete($produk->image);
        $produk->delete();
        return redirect()->route('produk.index');

    }
}
