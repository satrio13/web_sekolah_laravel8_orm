<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerModel extends Model
{
    protected $table = 'tb_banner';
    protected $fillable = ['gambar', 'judul', 'keterangan', 'link', 'button', 'is_active'];
}