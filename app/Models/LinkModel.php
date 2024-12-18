<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkModel extends Model
{
    protected $table = 'tb_link';
    protected $fillable = ['nama', 'link', 'is_active'];
}