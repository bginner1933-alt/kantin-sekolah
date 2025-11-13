<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = ['kode', 'id_kategori', 'id_produk', 'jumlah', 'total_harga'];
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    // Relasi many-to-many ke produk lewat tabel pivot "detail_transaksi"
    public function produks()
    {
        return $this->belongsToMany(Produk::class, 'detail_transaksi', 'id_transaksi', 'id_produk')
                    ->withPivot('jumlah', 'sub_total')
                    ->withTimestamps();
    }
}
