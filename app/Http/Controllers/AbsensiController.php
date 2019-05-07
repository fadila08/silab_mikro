<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\ViewAbsensiTransformer;
use Validator;
use App\Absensi;

class AbsensiController extends Controller
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
        $absensi = Absensi::all(); 

        return fractal()
            ->collection($absensi)
            ->transformWith(new ViewAbsensiTransformer)
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
            ->toArray();
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
        $this->validator($data->all())->validate();
        $user->nama = $request->get('nama', $user->nama);
        $user->nomor_induk = $request->get('nomor_induk', $user->nomor_induk);
        $user->email = $request->get('email', $user->email);
        $user->nomor_whatsapp = $request->get('nomor_whatsapp', $user->nomor_whatsapp);

        $user->save();

        return fractal()
            ->item($user)
            ->transformWith(new UserTransformer)
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
