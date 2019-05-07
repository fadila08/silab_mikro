<?php

namespace App\Transformers\Kelas;

use League\Fractal\TransformerAbstract;
use App\Nilai;

class ViewKelasTransformer extends TransformerAbstract
{
    public function transform(Kelas $kelas)
    {
      return [
        'id' => $kelas->id,
        'praktikum' => Praktikum::find($kelas->id_praktikum)->nama_praktikum,
        'id_praktikum' => $kelas->id_praktikum,
        'kelas' => $kelas->kelas,
        'tahun_pelajaran' => $kelas->tahun_pelajaran,
        'semester' => $kelas->semester
      ];
    }
}