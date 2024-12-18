<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrestasiSiswaModel extends Model
{
    protected $table = 'tb_prestasi_siswa';
    protected $fillable = ['id_tahun', 'nama', 'prestasi', 'nama_siswa', 'kelas', 'tingkat', 'jenis', 'keterangan', 'gambar'];

    function tahun()
    {
        return $this->belongsTo(TahunModel::class, 'id_tahun');
    }
    
}