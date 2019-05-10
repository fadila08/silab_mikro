<?php

namespace App\Http\Controllers;

use App\Nilai;
use App\Transformers\Nilai\NilaiTransformer;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index (Request $request, Nilai $nilai) {
        if ($request->get('kelas') != null || $request->get('kelas') != '') {
            $nilai = $nilai->where('id_kelas','=',$request->get('kelas'))->get();
            return fractal()
                ->collection($nilai)
                ->transformWith(new NilaiTransformer)
                ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                ->toArray();
        }
        else {
            $nilai = $nilai->all();
            return fractal()
                ->collection($nilai)
                ->transformWith(new NilaiTransformer)
                ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                ->toArray();
        }
    }
    
    public function store (Request $request, Nilai $nilai) {
        $nilai->create($request->all());
        return response()->json('Deal');
    }
    
    public function update (Request $request, Nilai $nilai) {
        $nilai = $nilai->update($request->all());
        return response()->json($nilai);
    }
    
    public function show (Request $request,Nilai $nilai) {
        
    }
    
    public function destroy (Nilai $nilai) {
        
    }
}
