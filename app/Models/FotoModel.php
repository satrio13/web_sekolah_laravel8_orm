<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoModel extends Model
{
    protected $table = 'tb_foto';
    protected $primaryKey = 'id_foto';
    protected $fillable = ['id_album', 'foto'];

    function album()
    {
        return $this->belongsTo(AlbumModel::class, 'id_album');
    }

}