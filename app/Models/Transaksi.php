<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = ['kode_transaksi', 'id_kategori', 'tanggal', 'total_harga'];
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

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_transaksi');
    }

}
