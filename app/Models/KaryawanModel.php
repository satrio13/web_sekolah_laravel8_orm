<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KaryawanModel extends Model
{
    protected $table = 'tb_karyawan';
    protected $fillable = ['nip', 'duk', 'niplama', 'nuptk', 'nokarpeg', 'golruang', 'statuspeg', 'nama', 'tmp_lahir', 'tgl_lahir', 'tmt_cpns', 'tmt_pns', 'jk', 'agama', 'alamat', 'pt', 'tingkat_pt', 'prodi', 'th_lulus', 'gambar', 'status', 'email', 'tugas'];
}