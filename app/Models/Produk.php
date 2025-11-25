<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class produk extends Model
{
    protected $fillable = ['nama_produk', 'harga', 'stok', 'kategori_id'];
    protected $visible  = ['nama_produk', 'harga', 'stok', 'kategori_id'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function transaksis()
    {

        return $this->belongsToMany(Transaksi::class, 'detail_transaksi', 'produk_id', 'transaksi_id')
            ->withPivot('jumlah', 'subtotal')
            ->withTimestamps();

    }

}
