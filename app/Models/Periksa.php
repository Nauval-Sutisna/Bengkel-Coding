<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periksa extends Model
{
    protected $table = 'periksa';
    
    protected $fillable = [
        'id_daftar_poli',
        'tgl_periksa',
        'catatan',
        'biaya_periksa'
    ];

    public function daftarPoli(){
        return $this->belongsTo(User::class, 'id_daftar_poli');
    }
    public function detailPeriksa(){
        return $this->hasMany(User::class, 'id_periksa');
    }
}
