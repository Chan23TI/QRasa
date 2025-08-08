<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ABC extends Model
{
    public $timestamps = false;
    use HasFactory;
   protected $table = 'ABC';
    protected $fillable = [
        'isi',
        'gambar1',
        'gambar2',

    ];
}
