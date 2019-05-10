<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\ViewAbsensiTransformer;
use App\Transformers\ViewAbsensiMHSTransformer;
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

    public function index(Request $request, Absensi $absensi)
    {
        if ($request->get('kelas') != null || $request->get('kelas') != '') {
            $absensi = $absensi->where('id_kelas','=',$request->get('kelas'))->get();
            return fractal()
                ->collection($absensi)
                ->transformWith(new ViewAbsensiTransformer)
                ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                ->toArray();
        }
        if ($request->get('mhs') != null || $request->get('mhs') != '') {
            $absensi = $absensi->where('id_mhs','=',$request->get('mhs'))->get();
            return fractal()
                ->collection($absensi)
                ->transformWith(new ViewAbsensiMHSTransformer)
                ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                ->toArray();
        }
        else {
            $absensi = Absensi::all(); 
            return fractal()
                ->collection($absensi)
                ->transformWith(new ViewAbsensiTransformer)
                ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                ->toArray();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Dosbim $dosbim)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Absensi $absensi)
    {
        return fractal()
            ->item($absensi)
            ->transformWith(new ViewAbsensiTransformer)
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
    public function update(Request $request, Absensi $absensi)
    {
        $old = $absensi;
        $absensi = $absensi->update($request->all());
        $absensi = Absensi::find($old['id']);
        $presentase = 0;

        if ($absensi['pertemuan_1'] != null) {
            $presentase += 25;
        }
        if ($absensi['pertemuan_2'] != null) {
            $presentase += 25;
        }
        if ($absensi['pertemuan_3'] != null) {
            $presentase += 25;
        }
        if ($absensi['pertemuan_4'] != null) {
            $presentase += 25;
        }
        $request['presentase'] = $presentase;
        $absensi->update($request->only(['presentase']));
        return response()->json($absensi);
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
