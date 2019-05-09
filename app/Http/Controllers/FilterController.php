<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\Filter\MahasiswaTransformer as MHS;
use App\Transformers\Filter\DosbimTransformer as DSN;
use App\User;

class FilterController extends Controller
{
    public function index(Request $request) {

        // Filter mahasiswa
        if ($request->get('mhs') == 1) {
            $data = [
                'praktikum' => $request->get('praktikum'),
                'kelas' => $request->get('kelas'),
                'semester' => $request->get('semester')
            ];
            // return response()->json($praktikum);

            return fractal()
                ->item($data)
                ->transformWith(new MHS())
                ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                ->toArray();
        }
        else if ($request->get('dsn') == 1) {
            $data = [
                'praktikum' => $request->get('praktikum'),
                'semester' => $request->get('semester')
            ];
            // return response()->json($praktikum);

            return fractal()
                ->item($data)
                ->transformWith(new DSN())
                ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                ->toArray();
        }
    }
}
