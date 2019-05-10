<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tugas;
use App\Nilai;
use Illuminate\Support\Facades\Storage;
use App\Transformers\Tugas\TugasTransformer;
use Carbon\Carbon;

class TugasController extends Controller
{

    public function index(Request $request, Tugas $tugas)
    {
        if ($request->get('kelas') != null || $request->get('kelas') != '') {
            $tugas = $tugas->where('id_kelas','=',$request->get('kelas'))->get();
            return fractal()
                ->collection($tugas)
                ->transformWith(new TugasTransformer)
                ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                ->toArray();
        }
        else { 
            return fractal()
                ->collection($tugas->all())
                ->transformWith(new TugasTransformer)
                ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                ->toArray();
        }
    }

    public function store(Request $request, Tugas $tugas)
    {
        $this->validate($request, [
            'judul' => 'required',
            'file' => 'file'   // pdf file only
        ]);
        
        if ($request->hasFile('file')){
            $file = $request->file('file')->store('lampiran');
        }
        else {
            $file = null;
        }

        $tugas = $tugas->create([
            'id_mhs' => $request->id_mhs,
            'id_kelas' => $request->id_kelas,
            'judul' => $request->judul,
            'tugas' => $file
        ]);

        $nilai = Nilai::where('id_mhs','=',$request->id_mhs)
        ->where('id_kelas','=',$request->id_kelas)
        ->first();

        $nilai->update([
            'status_laporan' => 1
        ]);
        return response()->json($tugas);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tugas $tugas)
    {
        if($tugas == null)
        {
            return response()->json(['error' => 'file tidak ditemukan']);
        }
        
        Storage::delete($tugas->file);
        
        $tugas->delete();

        return response()->json([
            'message' => 'data sudah terhapus',
        ]);
    }
}
