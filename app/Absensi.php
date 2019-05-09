<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
	protected $table = 'absensi';
  protected $fillable = [
    'id_mhs', 'id_kelas', 'pertemuan_1', 'pertemuan_2', 'pertemuan_3', 'pertemuan_4','presentase'
  ];
}