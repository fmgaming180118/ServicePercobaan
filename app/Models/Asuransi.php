<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Asuransi extends Model
{
    use HasFactory;

    protected $table = 'asuransi';

    public $timestamps = false;

    protected $primaryKey = 'id_asuransi';
    public $incrementing = false; // Jika tipe primary key bukan auto-increment
    protected $keyType = 'string';

    protected $fillable = [
        'id_asuransi',
        'nama_asuransi',
        'kontak',
        'alamat',
        'email',
    ];

    public function Kendaraan()
    {
        return $this->hasMany(Kendaraan::class, 'id_asuransi');
    }
}
