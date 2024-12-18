<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IsiAlumniModel extends Model
{
    protected $table = 'tb_isialumni';
    protected $fillable = ['nama', 'th_lulus', 'sma', 'pt', 'instansi', 'alamatins', 'hp', 'email', 'alamat', 'kesan', 'gambar', 'status'];
}