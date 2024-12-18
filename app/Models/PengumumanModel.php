<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengumumanModel extends Model
{
    protected $table = 'tb_pengumuman';
    protected $fillable = ['nama', 'isi', 'gambar', 'dibaca', 'id_user', 'is_active', 'hari', 'tgl', 'slug'];
    
    function user()
    {
        return $this->belongsTo(UserModel::class, 'id_user');
    }  

}