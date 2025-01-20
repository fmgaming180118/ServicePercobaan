<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPekerjaan extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = null;

    protected $table = 'detail_pekerjaan';
    protected $fillable = [
        'id_service',
        'id_pekerjaan',
        'status_pekerjaan',
    ];

    // Relasi ke service
    public function service()
    {
        return $this->belongsTo(Service::class, 'id_service', 'id_service');
    }

    // Relasi ke pekerjaan
    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class, 'id_pekerjaan', 'id_pekerjaan');
    }
    public function getKeyName()
    {
        return 'id_service'; // Mengembalikan id_service sebagai kunci unik
    }
}
