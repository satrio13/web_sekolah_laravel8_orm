<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilModel extends Model
{
    protected $table = 'tb_profil';
    protected $fillable = ['nama_web', 'jenjang', 'logo_web', 'logo_admin', 'favicon', 'meta_description', 'meta_keyword', 'profil', 'alamat', 'email', 'telp', 'fax', 'whatsapp', 'akreditasi', 'kurikulum', 'file', 'nama_kepsek', 'nama_operator', 'instagram', 'facebook', 'twitter', 'youtube', 'gambar'];
}