<?php
// app/Models/Produk.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $fillable = ['nama_produk', 'stok', 'harga', 'kategori_id']; // Menambahkan kategori_id di sini
    protected $visible  = ['nama_produk', 'stok', 'harga'];

    // Relasi dengan Transaksi (Many to Many)
    public function transaksis()
    {
        return $this->belongsToMany(Transaksi::class, 'detail_transaksi', 'id_produk', 'id_transaksi')
                    ->withPivot('jumlah', 'sub_total')
                    ->withTimestamps();
    }

    // Relasi dengan Kategori (Belongs to)
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id'); // Produk belongs to satu kategori
    }
}

