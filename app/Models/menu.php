<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class menu extends Model
{
    protected $fillable = [
        'nama',
        'deskripsi',
        'harga',
        'diskon',
        'stok',
        'kategori',
        'gambar',
    ];

    public function banner()
    {
        return $this->belongsTo(Banner::class);
    }
}
