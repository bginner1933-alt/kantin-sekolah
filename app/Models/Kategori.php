<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kategori extends Model
{
     protected $fillable = ['nama_kategori'];
    protected $visible = ['nama_kategori'];

    public function produks()
    {
        return $this->hasMany(Produk::class);
    }
}
