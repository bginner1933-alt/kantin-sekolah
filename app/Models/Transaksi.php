<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $fillable = ['kode_transaksi', 'tanggal', 'nama_pembeli', 'total_harga'];


    protected $casts = [
        'tanggal' => 'datetime',
    ];

    public function produks()
    {
        return $this->belongsToMany(Produk::class, 'detail_transaksi', 'transaksi_id', 'produk_id')
                    ->withPivot('jumlah', 'subtotal')
                    ->withTimestamps();
    }
}
