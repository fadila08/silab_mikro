<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
	protected $table = 'kelas';
	protected $guarded = array('id');
  protected $fillable = [
	  'id_praktikum', 'kelas', 'tahun_pelajaran', 'semester'
  ];
}
