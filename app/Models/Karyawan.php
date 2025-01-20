<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan';
    public $timestamps = false;

    protected $primaryKey = 'id_karyawan';
    public $incrementing = false; // Jika tipe primary key bukan auto-increment
    protected $keyType = 'string';

    protected $fillable = [
        'id_karyawan',
        'nama_karyawan',
        'jabatan',
        'id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
