<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
	protected $table = 'tugas_praktikum';
	protected $guarded = ['id'];
}
