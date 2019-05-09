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
            'mahasiswa' => [
                'id' => $absensi->id,
                'nbi' => User::find($absensi->id_mhs)->nomor_induk,
                'nama_mahasiswa' => User::find($absensi->id_mhs)->nama,
            ],
            'kelas' => [
                'id_kelas' => $absensi->id_kelas,
                'nam_kelas' => Kelas::find($absensi->id_kelas)->kelas,
            ],
            'pertemuan_1' => $absensi->pertemuan_1,
            'pertemuan_2' => $absensi->pertemuan_2,
            'pertemuan_3' => $absensi->pertemuan_3,
            'pertemuan_4' => $absensi->pertemuan_4,
            'presentase' => $absensi->presentase,
        ];
    }
}