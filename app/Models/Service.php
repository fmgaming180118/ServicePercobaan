<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Service extends Model
{
    use HasFactory;

    protected $table = 'service';

    protected $primaryKey = 'id_service';
    public $incrementing = false; // Jika tipe primary key bukan auto-increment
    protected $keyType = 'string';

    protected $fillable = [
        'id_service',
        'no_polisi',
        'id_customer',
        'tanggal',
        'jenis_service',
        'status',
        'catatan',
        'id_karyawan',
    ];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'no_polisi', 'no_polisi');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer');
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }

    public function detailPekerjaan()
    {
        return $this->hasMany(DetailPekerjaan::class, 'id_service', 'id_service');
    }
}
