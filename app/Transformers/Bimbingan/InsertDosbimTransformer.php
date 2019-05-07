<?php

namespace App\Transformers\Bimbingan;

use App\Dosbim;
use League\Fractal\TransformerAbstract;
use App\User;
use App\Kelas;

class InsertDosbimTransformer extends TransformerAbstract
{
    public function transform(Dosbim $dosbim)
    {
        return [
            'mahasiswa' => User::find($dosbim->id_mhs)->nama,
            'dosen' => User::find($dosbim->id_dosbim)->nama,
            'kelas' => Kelas::find($dosbim->id_kelas)->kelas,
            'success' => 'Data berhasil ditambahkan',
        ];
    }
}