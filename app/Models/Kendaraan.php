<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kendaraan extends Model
{
    use HasFactory;

    protected $table = 'kendaraan';

    public $timestamps = false;
    protected $primaryKey = 'no_polisi';
    public $incrementing = false; // Jika tipe primary key bukan auto-increment
    protected $keyType = 'string';

    protected $fillable = [
        'no_polisi',
        'nama_kendaraan',
        'warna',
        'id_asuransi',
    ];

    public function asuransi()
    {
        return $this->belongsTo(Asuransi::class, 'id_asuransi');
    }

    public function service()
    {
        return $this->hasMany(Service::class, 'no_polisi', 'no_polisi');
    }
}
