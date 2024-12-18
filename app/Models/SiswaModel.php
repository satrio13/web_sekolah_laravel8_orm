<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiswaModel extends Model
{
    protected $table = 'tb_siswa';
    protected $fillable = ['id_tahun', 'jml1pa', 'jml1pi', 'jml2pa', 'jml2pi', 'jml3pa', 'jml3pi'];

    function tahun()
    {
        return $this->belongsTo(TahunModel::class, 'id_tahun');
    }

}