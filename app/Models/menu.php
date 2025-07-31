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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pesans()
    {
        return $this->belongsToMany(Pesan::class)->withPivot('quantity');
    }
}
