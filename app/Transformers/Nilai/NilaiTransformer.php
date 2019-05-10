<?php

namespace App\Transformers\Nilai;

use League\Fractal\TransformerAbstract;
use App\Nilai;
use App\Kelas;
use App\User;

class NilaiTransformer extends TransformerAbstract
{
    public function transform(Nilai $nilai)
    {
      return [
        'id' => $nilai->id,
        'mahasiswa' => [
            'id' => $nilai->id_mhs,
            'nama_mahasiswa' => User::find($nilai->id_mhs)->nama,
            'nomor_induk' => User::find($nilai->id_mhs)->nomor_induk
        ],
        'kelas' => [
            'id' => $nilai->id_kelas,
            'nama_kelas' => Kelas::find($nilai->id_kelas)->kelas
        ],
        'nilai' => [
            "tugas_pendahuluan_1" => $nilai->tugas_pendahuluan_1,
            "tugas_pendahuluan_2" => $nilai->tugas_pendahuluan_2,
            "tugas_pendahuluan_3" => $nilai->tugas_pendahuluan_3,
            "tugas_pendahuluan_4" => $nilai->tugas_pendahuluan_4,
            "abstrak_praktikum_1" => $nilai->abstrak_praktikum_1,
            "abstrak_praktikum_2" => $nilai->abstrak_praktikum_2,
            "abstrak_praktikum_3" => $nilai->abstrak_praktikum_3,
            "abstrak_praktikum_4" => $nilai->abstrak_praktikum_4,
            "aktivitas_praktikum_1" => $nilai->aktivitas_praktikum_1,
            "aktivitas_praktikum_2" => $nilai->aktivitas_praktikum_2,
            "aktivitas_praktikum_3" => $nilai->aktivitas_praktikum_3,
            "aktivitas_praktikum_4" => $nilai->aktivitas_praktikum_4,
            "tugas_paska_praktikum_1" => $nilai->tugas_paska_praktikum_1,
            "tugas_paska_praktikum_2" => $nilai->tugas_paska_praktikum_2,
            "tugas_paska_praktikum_3" => $nilai->tugas_paska_praktikum_3,
            "tugas_paska_praktikum_4" => $nilai->tugas_paska_praktikum_4,
            "tes_akhir" => $nilai->tes_akhir,
            "nilai_bimbingan_dosen" => $nilai->nilai_bimbingan_dosen,
            "status_laporan" => $nilai->status_laporan,
            "nilai_akhir" => $nilai->nilai_akhir,
            "grade" => $nilai->grade
        ]
      ];
    }
}