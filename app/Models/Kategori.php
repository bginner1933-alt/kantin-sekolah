<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = ['nama', 'alamat', 'telepon'];
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_kategori');
    }
}
