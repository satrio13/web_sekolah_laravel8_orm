<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EkstrakurikulerModel extends Model
{
    protected $table = 'tb_ekstrakurikuler';
    protected $fillable = ['nama_ekstrakurikuler', 'gambar', 'keterangan', 'slug'];
}