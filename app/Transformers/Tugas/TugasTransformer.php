<?php

namespace App\Transformers\Tugas;

use League\Fractal\TransformerAbstract;
use App\User;
use App\Kelas;
use App\Tugas;

class TugasTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Tugas $tugas)
    {
        return [
            'mahasiswa' => [
                'nomor_induk' => $tugas->id_mhs,
                'nama_mahasiswa' => User::find($tugas->id_mhs)->nama
            ],
            'kelas' => [
                'id' => $tugas->id_kelas,
                'nama_kelas' => Kelas::find($tugas->id_kelas)->kelas
            ],
            'file' => [
                'file_name' => $tugas->tugas
            ]
        ];
    }
}
