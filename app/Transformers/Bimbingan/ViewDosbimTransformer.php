<?php

namespace App\Transformers\Bimbingan;

use App\Dosbim;
use League\Fractal\TransformerAbstract;
use App\User;
use App\Kelas;

class ViewDosbimTransformer extends TransformerAbstract
{
    public function transform(Dosbim $dosbim)
    {
		if (!isset($dosbim->id_dosbim) || $dosbim->id_dosbim == null) {
            $dosbim->id_dosbim = '';
            $nama_dosbim = 'NULL';
		}
		else {
			$nama_dosbim = User::find($dosbim->id_dosbim)->nama;
		}
		
        return [
            'mahasiswa' => [
                'id' => $dosbim->id_mhs,
                'nomor_induk' => User::find($dosbim->id_mhs)->nomor_induk,
                'nama_mahasiswa' => User::find($dosbim->id_mhs)->nama
            ],
            'dosen' => [
                'id' => $dosbim->id_dosbim,
                'nama_dosen' => $nama_dosbim
            ],
            'kelas' => [
                'id' => $dosbim->id_kelas,
                'nama_kelas' => Kelas::find($dosbim->id_kelas)->kelas,
            ],
            'id' => $dosbim->id
        ];
    }
}