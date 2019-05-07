<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\Kelas\ViewPraktikumTransformer;
use App\Praktikum;

class PraktikumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Praktikum $praktikum)
    {
        return fractal()
          ->collection($praktikum->all())
          ->transformWith(new ViewPraktikumTransformer)
          ->toArray();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Praktikum $praktikum)
    {
        $praktikum = $praktikum->create($request->all());

        $response = fractal()
            ->item($praktikum)
            ->transformWith(new ViewPraktikumTransformer)
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
    public function show(Praktikum $praktikum)
    {
        return fractal()
          ->item($praktikum)
          ->transformWith(new ViewPraktikumTransformer)
          ->toArray();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Praktikum $praktikum)
    {
        $praktikum = $praktikum->update($request->all());

        $response = fractal()
            ->item($praktikum)
            ->transformWith(new ViewPraktikumTransformer)
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
    public function destroy(Praktikum $praktikum)
    {
        $praktikum->delete();
        return response()->json([
          'message' => 'data sudah terhapus',
        ]);
    }
}
