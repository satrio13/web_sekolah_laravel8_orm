<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuruModel extends Model
{
    protected $table = 'tb_guru';
    protected $fillable = ['nip', 'duk', 'niplama', 'nuptk', 'nokarpeg', 'golruang', 'statuspeg', 'nama', 'tmp_lahir', 'tgl_lahir', 'tmt_cpns', 'tmt_pns', 'jk', 'agama', 'alamat', 'pt', 'tingkat_pt', 'prodi', 'th_lulus', 'jabatan', 'gambar', 'status', 'email', 'statusguru'];
}