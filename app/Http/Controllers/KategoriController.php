<?php
namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\Transaksi;

class KategoriController extends Controller
{

    public function index()
    {
        $kategori = Kategori::all();
        return view('kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'       => 'required',
            'alamat'     => 'required',
            'no_telepon' => 'required',
        ]);

        $kategori             = new Kategori();
        $kategori->nama       = $request->nama;
        $kategori->alamat     = $request->alamat;
        $kategori->no_telepon = $request->no_telepon;
        $kategori->save();

        return redirect()->route('kategori.index');
    }

    public function show(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategori.show', compact('kategori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nama'       => 'required',
            'alamat'     => 'required',
            'no_telepon' => 'required',
        ]);

        $kategori             = Kategori::findOrFail($id);
        $kategori->nama       = $request->nama;
        $kategori->alamat     = $request->alamat;
        $kategori->no_telepon = $request->no_telepon;
        $kategori->save();

        return redirect()->route('kategori.index');
    }

   public function destroy($id)
{
    // Check if there are any related transaksis records
    $transaksis = Transaksi::where('id_kategori', $id)->count();

    if ($transaksis > 0) {
        return redirect()->route('kategori.index')->with('error', 'Cannot delete category because it has related transactions.');
    }

    // Proceed to delete the category if no related transaksis
    Kategori::destroy($id);

    return redirect()->route('kategori.index')->with('success', 'Category deleted successfully.');
}

}
