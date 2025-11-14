<?php
namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{

    public function index()
    {
        $pelanggan = Pelanggan::all();
        return view('pelanggan.index', compact('pelanggan'));
    }

    public function create()
    {
        return view('pelanggan.create');
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

        $pelanggan             = new Pelanggan();
        $pelanggan->nama       = $request->nama;
        $pelanggan->alamat     = $request->alamat;
        $pelanggan->no_telepon = $request->no_telepon;
        $pelanggan->save();

        return redirect()->route('pelanggan.index');
    }

    public function show(string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('pelanggan.show', compact('pelanggan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('pelanggan.edit', compact('pelanggan'));
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

        $pelanggan             = Pelanggan::findOrFail($id);
        $pelanggan->nama       = $request->nama;
        $pelanggan->alamat     = $request->alamat;
        $pelanggan->no_telepon = $request->no_telepon;
        $pelanggan->save();

        return redirect()->route('pelanggan.index');
    }

    public function destroy(string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();
        return redirect()->route('pelanggan.index');
    }
}
