<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pekerjaan extends Model
{
    use HasFactory;

    protected $table = 'pekerjaan';
    public $timestamps = false;

    protected $primaryKey = 'id_pekerjaan';
    public $incrementing = false; // Jika tipe primary key bukan auto-increment
    protected $keyType = 'string';

    protected $fillable = [
        'id_pekerjaan',
        'nama_pekerjaan'
    ];

    public function detailPekerjaan()
    {
        return $this->hasMany(DetailPekerjaan::class, 'id_pekerjaan', 'id_pekerjaan');
    }

}
