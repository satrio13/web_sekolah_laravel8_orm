<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgendaModel extends Model
{
    protected $table = 'tb_agenda';
    protected $fillable = ['nama_agenda', 'berapa_hari', 'tgl', 'tgl_mulai', 'tgl_selesai', 'jam_mulai', 'jam_selesai', 'keterangan', 'tempat', 'gambar', 'slug'];
}