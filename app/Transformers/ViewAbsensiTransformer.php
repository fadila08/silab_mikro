<?php

namespace App\Transformers;

use App\Absensi;
use League\Fractal\TransformerAbstract;
use App\User;
use App\Kelas;

class ViewAbsensiTransformer extends TransformerAbstract
{
    public function transform(Absensi $absensi)
    {
        return [
            'id' => $absensi->id,
      		'nbi' => User::find($absensi->id_mhs)->nomor_induk,
            'mahasiswa' => User::find($absensi->id_mhs)->nama,
            'kelas' => Kelas::find($absensi->id_kelas)->kelas,
            'presentase' => $absensi->presentase,
        ];
    }
}