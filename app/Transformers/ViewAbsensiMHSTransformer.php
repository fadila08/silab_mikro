<?php

namespace App\Transformers;

use App\Absensi;
use League\Fractal\TransformerAbstract;
use App\User;
use App\Kelas;
use App\Nilai;
use App\Praktikum;

class ViewAbsensiMHSTransformer extends TransformerAbstract
{
    public function transform(Absensi $absensi)
    {
        $kelas = Kelas::find($absensi->id_kelas);
        $nilai = Nilai::where('id_mhs','=',$absensi->id_mhs)
        ->where('id_kelas','=',$absensi->id_kelas)->first();

        return [
            'mahasiswa' => [
                'id' => $absensi->id_mhs,
                'nomor_induk' => User::find($absensi->id_mhs)->nomor_induk,
                'nama_mahasiswa' => User::find($absensi->id_mhs)->nama,
            ],
            'kelas' => [
                'id_kelas' => $absensi->id_kelas,
                'nama_kelas' => $kelas->kelas,
            ],
            'praktikum' => [
                'id' => $kelas->id_praktikum,
                'nama_praktikum' => Praktikum::find($kelas->id_praktikum)->nama_praktikum
            ],
            'pertemuan' => [
                'pertemuan_1' => $absensi->pertemuan_1,
                'pertemuan_2' => $absensi->pertemuan_2,
                'pertemuan_3' => $absensi->pertemuan_3,
                'pertemuan_4' => $absensi->pertemuan_4
            ],
            'nilai' => [
                'grade' => $nilai->grade,
                'status_laporan' => $nilai->status_laporan
            ],
            'presentase' => $absensi->presentase,
            'id' => $absensi->id
        ];
    }
}