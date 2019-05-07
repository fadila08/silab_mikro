<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dosbim extends Model
{
    protected $table = 'mhs_dosbim';
    protected $fillable = [
        'id_mhs', 'id_dosbim', 'id_kelas'
    ];
}
