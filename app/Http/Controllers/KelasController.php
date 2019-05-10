<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\Kelas\ViewKelasTransformer;
use App\Kelas;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Kelas $kela)
    {
        if ($request->get('mhs') != null || $request->get('mhs') != '') {
            $kela = $kela->where('id_mhs','=',$request->get('mhs'))->get();
            return fractal()
              ->collection($kela->all())
              ->transformWith(new ViewKelasTransformer)
              ->toArray();
        }
        else { 
            return fractal()
              ->collection($kela->all())
              ->transformWith(new ViewKelasTransformer)
              ->toArray();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Kelas $kela)
    {
        $kela = $kela->create($request->all());

        $response = fractal()
            ->item($kela)
            ->transformWith(new ViewKelasTransformer)
            ->addMeta([
                'message' => 'Success!',
            ])
            ->toArray();
                    
        return response()->json($response, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Kelas $kela)
    {
        return fractal()
          ->item($kela)
          ->transformWith(new ViewKelasTransformer)
          ->toArray();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kelas $kela)
    {
        $kela->id_praktikum = $request->id_praktikum;
        $kela->kelas = $request->kelas;
        $kela->tahun_pelajaran = $request->tahun_pelajaran;
        $kela->semester = $request->semester;
        $kela->update();

        $response = fractal()
            ->item($kela)
            ->transformWith(new ViewKelasTransformer)
            ->addMeta([
                'message' => 'Success!',
            ])
            ->toArray();
                    
        return response()->json($response, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kelas $kela)
    {
        $kela->delete();
        return response()->json([
          'message' => 'data sudah terhapus',
        ]);
    }
}
