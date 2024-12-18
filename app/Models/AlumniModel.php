<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlumniModel extends Model
{
    protected $table = 'tb_alumni';
    protected $fillable = ['id_tahun', 'jml_l', 'jml_p'];

    function tahun()
    {
        return $this->belongsTo(TahunModel::class, 'id_tahun');
    }
    
}