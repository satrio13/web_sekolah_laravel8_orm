<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KurikulumModel extends Model
{
    protected $table = 'tb_kurikulum';
    protected $primaryKey = 'id_kurikulum';
    protected $fillable = ['mapel', 'alokasi', 'kelompok', 'no_urut', 'is_active'];

    function rekap_un() 
    {
        return $this->hasMany(RekapUNModel::class);
    }

    function rekap_us() 
    {
        return $this->hasMany(RekapUSModel::class);
    }

}