<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\Bimbingan\InsertDosbimTransformer;
use App\Transformers\Bimbingan\ViewDosbimTransformer;
use Validator;
use App\Dosbim;
use Excel;
use App\Imports\DosbimImport;

class DosbimController extends Controller
{
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'id_mhs' => 'required',
            'id_dosbim' => 'required',
            'id_kelas' => 'required',
        ]);
    }

    public function index()
    {
        $dosbim = Dosbim::all(); 

        return fractal()
            ->collection($dosbim)
            ->transformWith(new ViewDosbimTransformer)
            ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
            ->toArray();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Dosbim $dosbim)
    {
        $this->validator($request->all())->validate();

        $dosbim = $dosbim->create([
            'id_mhs' => $request->id_mhs,
            'id_dosbim' => $request->id_dosbim,
            'id_kelas' => $request->id_kelas
        ]);

        $response = fractal()
            ->item($dosbim)
            ->transformWith(new InsertDosbimTransformer)
            ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
            ->toArray();
        return response()->json($response, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Dosbim $dosbim)
    {
        return fractal()
            ->item($dosbim)
            ->transformWith(new ViewDosbimTransformer)
            ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
            ->toArray();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dosbim $dosbim)
    {
        $dosbim->id_dosbim = $request->id_dosbim;

        $dosbim->update();

        return fractal()
            ->item($dosbim)
            ->transformWith(new ViewDosbimTransformer)
            ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
            ->toArray();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function import(Request $request)
    {
        $datas = Excel::import(new DosbimImport, $request->file('file'));
        return response()->json([
            'message' => 'yay! :)'
        ]);
    }
}
