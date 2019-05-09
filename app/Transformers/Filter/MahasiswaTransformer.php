<?php

namespace App\Transformers\Filter;

use League\Fractal\TransformerAbstract;
use App\Transformers\ViewUserTransformer;
use App\User;
use App\Absensi;
use App\Kelas;

class MahasiswaTransformer extends TransformerAbstract
{
    public function transform($data)
    {
        $data = (object) $data;
        if ($data->praktikum == null && $data->kelas == null && $data->semester == null) {
            $user = User::where('id_roles','=',5)->get();
            return [
                'user' => $user
            ];
        }
        else if ($data->praktikum != null && $data->kelas != null && $data->semester != null) {
            $kelas = Kelas::where('id_praktikum','=',$data->praktikum)
            ->where('kelas','=',$data->kelas)
            ->where('semester','=',$data->semester)->first();
            $user = [];
            $absensi = Absensi::where('id_kelas',$kelas->id)->get();
            foreach ($absensi as $i) {
                $user[] = User::find($i->id_mhs);
            }
            return [
                'user' => $user
            ];
        }
    }
}
