<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class meja extends Model
{
    protected $fillable = [
        'nomor_meja',
        'qr_code',
    ];

    public function pesans()
    {
        return $this->hasMany(Pesan::class);
    }
}
