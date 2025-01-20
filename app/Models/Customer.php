<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer';
    
    public $timestamps = false;
    protected $primaryKey = 'id_customer';
    protected $keyType = 'string';

    protected $fillable = [
        'nama_customer',
        'no_telp',
        'alamat',
        'id',
    ];

    public function Service(){
        return $this->hasMany(Service::class, 'id_customer', 'id_customer');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id_customer');
    }
}
