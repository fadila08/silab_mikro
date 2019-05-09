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
        // ubah data parameter to objek
        $data = (object) $data;

        // kondisi p null, k null, s null
        if ($data->praktikum == null && $data->kelas == null && $data->semester == null) {
            $user = User::where('id_roles','=',5)->get();
            return [
                'user' => $this->userSerilizer($user)
            ];
        }

        else {
            // get kelas berdasarkan kriteria
            $kelas = $this->normalize($data);
            
            // inisialisasi user array
            $user = [];

            // get data user (hasil pencarian) by absensi
            foreach ($kelas as $i) {
                $absensi[] = Absensi::where('id_kelas',$i->id)->get();
            }
            foreach ($absensi as $i) {
                foreach ($i as $x) {
                    if ( $x->id_mhs != null ) {
                        $user[] = User::find($x->id_mhs);
                    }
                }
            }

            // return hasil
            return [
                'user' => $this->userSerilizer($user)
            ];
        }
    }

    // serialize hasil
    public function userSerilizer($data) {
        return collect($data)
            ->transformWith(new ViewUserTransformer)
            ->serializeWith(new \Spatie\Fractalistic\ArraySerializer());
    }

    // normalisasi kondisi
    public function normalize($data) {
        // kondisi p !null, k !null, s !null
        if ($data->praktikum != null && $data->kelas != null && $data->semester != null) {
            $kelas = Kelas::where('id_praktikum','=',$data->praktikum)
                ->where('kelas','=',$data->kelas)
                ->where('semester','=',$data->semester)->get();
        }
        // kondisi p !null, k null, s null
        else if ($data->praktikum != null && $data->kelas == null && $data->semester == null) {
            $kelas = Kelas::where('id_praktikum','=',$data->praktikum)->get();
        }
        // kondisi p null, k !null, s null
        if ($data->praktikum == null && $data->kelas != null && $data->semester == null) {
            $kelas = Kelas::where('kelas','=',$data->kelas)->get();
        }
        // kondisi p null, k null, s !null
        if ($data->praktikum == null && $data->kelas == null && $data->semester != null) {
            $kelas = Kelas::where('semester','=',$data->semester)->get();
        }
        // kondisi p !null, k !null, s null
        else if ($data->praktikum != null && $data->kelas != null && $data->semester == null) {
            $kelas = Kelas::where('id_praktikum','=',$data->praktikum)
                ->where('kelas','=',$data->kelas)->get();
        }
        // kondisi p !null, k null, s !null
        else if ($data->praktikum != null && $data->kelas == null && $data->semester != null) {
            $kelas = Kelas::where('id_praktikum','=',$data->praktikum)
                ->where('semester','=',$data->semester)->get();
        }
        // kondisi p !null, k null, s !null
        else if ($data->praktikum == null && $data->kelas != null && $data->semester != null) {
            $kelas = Kelas::where('kelas','=',$data->kelas)
                ->where('semester','=',$data->semester)->get();
        }

        return $kelas;
    }
}
