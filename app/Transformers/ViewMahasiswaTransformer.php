<?php

namespace App\Transformers;

use App\Dosbim;
use League\Fractal\TransformerAbstract;
use App\User;
use App\Kelas;

class ViewMahasiswaTransformer extends TransformerAbstract
{
    public function transform(Dosbim $dosbim)
    {
        return [
            'id' => $dosbim->id,
            'nama_mahasiswa' => User::find($dosbim->id_mhs)->nama,
            'nbi_mahasiswa' => User::find($dosbim->id_mhs)->nomor_induk,
        ];
    }
}