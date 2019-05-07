<?php

namespace App\Transformers\Kelas;

use League\Fractal\TransformerAbstract;
use App\Praktikum;

class ViewPraktikumTransformer extends TransformerAbstract
{
    public function transform(Praktikum $praktikum)
    {
      return [
      	'id' => $praktikum->id,
    		'nama_praktikum' => $praktikum->nama_praktikum
      ];
    }
}