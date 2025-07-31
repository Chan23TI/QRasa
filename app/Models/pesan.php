<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pesan extends Model
{
    protected $fillable = [
        'total',
        'user_id',
        'status',
        'payment_method',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class)->withPivot('quantity');
    }
}
