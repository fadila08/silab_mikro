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
            'id' => $dosbim->id,
            'nbi' => User::find($dosbim->id_mhs)->nomor_induk,
            'mahasiswa' => User::find($dosbim->id_mhs)->nama,
            'id_dosen' => $dosbim->id_dosbim,
            'dosen' => $nama_dosbim,
            'kelas' => Kelas::find($dosbim->id_kelas)->kelas,
        ];
    }
}