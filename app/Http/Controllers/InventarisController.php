<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Transformers\InventarisTransformer;
use App\Transformers\UserTransformer;
use App\Transformers\ViewUserTransformer;
use Auth;
use JWTAuth;
use App\Inventaris;

class InventarisController extends Controller
{
    public function __contruct(Request $request)
    {
        // $this->middleware('dosbim')
    }

    public function index(Inventaris $inventaris)
    {
        $inventaris = $inventaris->all(); 

        return fractal()
            ->collection($inventaris)
            ->transformWith(new InventarisTransformer)
            ->toArray();
    }

    public function show(Inventaris $inventaris)
    {
        return fractal()
            ->item($inventaris)
            ->transformWith(new InventarisTransformer)
            ->toArray();
    }

    public function store(Request $request, Inventaris $inventaris)
    {
        // $this->validate($request, [
        //     'nama' => 'required',
        //     'nomor_induk' => 'required|unique:users'
        // ]);

        $inventaris = $inventaris->create([
            'nama_barang' => ucwords(strtolower($request->nama_barang)),
            'jumlah' => $request->jumlah,
            'kondisi' => $request->kondisi,
        ]);
        
        $response = fractal()
        ->item($inventaris)
        ->transformWith(new InventarisTransformer)
        // ->addMeta([
        //     'token' => JWTAuth::fromUser($user),
        // ])
        ->toArray();
                    
        return response()->json($response, 201);

    }

    public function destroy(Request $request, Inventaris $inventaris)
    {
        $inventaris->delete();

        return response()->json([
            'message' => 'data sudah terhapus',
        ]);
    }
}
