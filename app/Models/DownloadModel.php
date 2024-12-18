<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DownloadModel extends Model
{
    protected $table = 'tb_download';
    protected $fillable = ['nama_file', 'file', 'hits', 'id_user', 'is_active'];

    function user()
    {
        return $this->belongsTo(UserModel::class, 'id_user');
    } 
    
}