<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class banner extends Model
{
    protected $fillable = [
        'nama',
        'gambar',
    ];
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
