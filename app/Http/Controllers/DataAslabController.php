<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Transformers\InsertDataUserTransformer;
use App\Transformers\UserTransformer;
use App\Transformers\ViewUserTransformer;
use Auth;
use JWTAuth;
use App\User;

class DataAslabController extends Controller
{
    public function __contruct(Request $request)
    {
        // $this->middleware('aslab')
    }

    public function index(User $user)
    {
        $user = $user->where('id_roles', '=', 3)->get(); 

        return fractal()
            ->collection($user)
            ->transformWith(new ViewUserTransformer)
            ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
            ->toArray();
    }

    public function show(User $user)
    {
        return fractal()
            ->item($user)
            ->transformWith(new UserTransformer)
            ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
            ->toArray();
    }

    public function store(Request $request, User $user)
    {
        $this->validate($request, [
            'nama' => 'required',
            'nomor_induk' => 'required|unique:users'
        ]);

        if (trim($request->password) == '') {
            $password = $request->nomor_induk;
        } else {
            $password = $request->password;
        };

        $user = $user->create([
            'username' => $request->nomor_induk,
            'password' => Hash::make($password),
            'nama' => ucwords(strtolower($request->nama)),
            'nomor_induk' => $request->nomor_induk,
            'email' => $request->email,
            'nomor_whatsapp' => $request->nomor_whatsapp,
            'id_roles' => 3
        ]);

        $response = fractal()
        ->item($user)
        ->transformWith(new InsertDataUserTransformer)
        ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
        ->addMeta([
            'token' => JWTAuth::fromUser($user),
        ])
        ->toArray();
                    
        return response()->json($response, 201);

    }

    public function update(Request $request, User $user)
    {
        $user->username = $request->nomor_induk;
        $user->nama = $request->nama;
        $user->nomor_induk = $request->nomor_induk;
        $user->email = $request->email;
        $user->nomor_whatsapp = $request->nomor_whatsapp;

        $user->save();

        return fractal()
            ->item($user)
            ->transformWith(new UserTransformer)
            ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
            ->toArray();
    }

    public function destroy(Request $request, User $user)
    {
        $user->delete();

        return response()->json([
            'message' => 'data sudah terhapus',
        ]);
    }
}
