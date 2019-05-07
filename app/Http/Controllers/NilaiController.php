<?php

namespace App\Http\Controllers;

use App\Nilai;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index (Nilai $nilai) {
        return response()->json($nilai->all());
    }
    
    public function store (Request $request, Nilai $nilai) {
        $nilai->create($request->all());
        return response()->json('Deal');
    }
    
    public function update (Request $request, Nilai $nilai) {
        $nilai->update($request->all());
        return response()->json($nilai);
    }
    
    public function show (Nilai $nilai) {
        
    }
    
    public function destroy (Nilai $nilai) {
        
    }

    public function pendahuluan_update (Request $request, Nilai $nilai) {
        $nilai->update($request->only(['tugas_pendahuluan_1','tugas_pendahuluan_2','tugas_pendahuluan_3','tugas_pendahuluan_4']));
        return response()->json($nilai);
    }

    public function abstrak_update (Request $request, Nilai $nilai) {
        $nilai->update($request->only(['tugas_abstrak_1','tugas_abstrak_2','tugas_abstrak_3','tugas_abstrak_4']));
        return response()->json($nilai);
    }

    public function aktivitas_update (Request $request, Nilai $nilai) {
        $nilai->update($request->only(['aktivitas_praktikum_1','aktivitas_praktikum_2','aktivitas_praktikum_3','aktivitas_praktikum_4']));
        return response()->json($nilai);
    }

    public function tugas_paska_update (Request $request, Nilai $nilai) {
        $nilai->update($request->only(['tugas_paska_praktikum_1','tugas_paska_praktikum_2','tugas_paska_praktikum_4','tugas_paska_praktikum_4']));
        return response()->json($nilai);
    }
}
