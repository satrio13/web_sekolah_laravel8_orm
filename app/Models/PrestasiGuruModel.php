<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrestasiGuruModel extends Model
{
    protected $table = 'tb_prestasi_guru';
    protected $fillable = ['id_tahun', 'nama', 'prestasi', 'nama_guru', 'tingkat', 'jenis', 'keterangan', 'gambar'];

    function tahun()
    {
        return $this->belongsTo(TahunModel::class, 'id_tahun');
    }

}