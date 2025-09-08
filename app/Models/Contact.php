<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory;
    protected $table = 'contact';
    public $timestamps = false;
    protected $fillable = [
        'wa',
        'ig',
        'fb',
        'email',
    ];
}
