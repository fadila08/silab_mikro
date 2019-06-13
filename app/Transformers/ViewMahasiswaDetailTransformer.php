<?php

namespace App\Transformers;

use App\Dosbim;
use League\Fractal\TransformerAbstract;
use App\User;
use App\Kelas;
use App\Praktikum;

class ViewMahasiswaDetailTransformer extends TransformerAbstract
{
    public function transform(Dosbim $dosbim)
    {
        
        $idPrak = Kelas::find($dosbim->id_kelas)->id_praktikum;
        
        return [
            'id' => $dosbim->id,
            'nama_mahasiswa' => User::find($dosbim->id_mhs)->nama,
            'nbi_mahasiswa' => User::find($dosbim->id_mhs)->nomor_induk,
            'nama_praktikum' => Praktikum::find($idPrak)->nama_praktikum,
            'thn_pel' => Kelas::find($dosbim->id_kelas)->tahun_pelajaran,
            'semester' => Kelas::find($dosbim->id_kelas)->semester,
            'kelas' => Kelas::find($dosbim->id_kelas)->kelas,
            'wa' => User::find($dosbim->id_mhs)->nomor_whatsapp,
            'email' => User::find($dosbim->id_mhs)->email
        ];
    }
}