<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $fillable = ['nama_produk', 'stok', 'harga'];
    protected $visible  = ['nama_produk', 'stok', 'harga'];

    public function transaksis()
    {
        return $this->belongsToMany(Transaksi::class, 'detail_transaksi', 'id_produk', 'id_transaksi')
                    ->withPivot('jumlah', 'sub_total')
                    ->withTimestamps();
    }
}
