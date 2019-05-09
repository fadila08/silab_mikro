<?php

namespace App\Transformers\Filter;

use League\Fractal\TransformerAbstract;
use App\Transformers\ViewUserTransformer;
use App\User;
use App\Dosbim;
use App\Kelas;

class DosbimTransformer extends TransformerAbstract
{
    public function transform($data)
    {
        // ubah data parameter to objek
        $data = (object) $data;

        // kondisi p null, s null
        if ($data->praktikum == null && $data->semester == null) {
            $user = User::where('id_roles','=',4)->get();
            return [
                'user' => $this->userSerilizer($user)
            ];
        }

        else {
            // get kelas berdasarkan kriteria
            $kelas = $this->normalize($data);
            
            // inisialisasi user array
            $user = [];

            // get data user (hasil pencarian) by dosbim
            foreach ($kelas as $i) {
                $dosbim[] = Dosbim::where('id_kelas',$i->id)->get();
            }
            foreach ($dosbim as $i) {
                foreach ($i as $x) {
                    if ( $x->id_dosbim != null ) {
                        $user[] = User::find($x->id_dosbim);
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
        // kondisi p !null, s !null
        if ($data->praktikum != null && $data->semester != null) {
            $kelas = Kelas::where('id_praktikum','=',$data->praktikum)
                ->where('semester','=',$data->semester)->get();
        }
        // kondisi p !null, s null
        else if ($data->praktikum != null && $data->semester == null) {
            $kelas = Kelas::where('id_praktikum','=',$data->praktikum)->get();
        }

        // kondisi p null, s !null
        if ($data->praktikum == null && $data->semester != null) {
            $kelas = Kelas::where('semester','=',$data->semester)->get();
        }

        return $kelas;
    }
}
