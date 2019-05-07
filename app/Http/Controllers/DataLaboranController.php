<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use Auth;
use App\Transformers\InsertDataUserTransformer;
use App\Transformers\UserTransformer;
use App\Transformers\ViewUserTransformer;

class DataLaboranController extends Controller
{
    public function index(User $user)
    {
        $user = $user->where('id_roles', '=', 2)->get(); 

        return fractal()
            ->collection($user)
            ->transformWith(new ViewUserTransformer)
            ->toArray();
    }

    public function show(User $user)
    {
        return fractal()
            ->item($user)
            ->transformWith(new UserTransformer)
            ->toArray();
    }

    public function store(Request $request, User $user)
    {
        $this->validate($request, [
            'nama' => 'required',
            'nomor_induk' => 'required|unique:users'
        ]);

        if ($request->pass_otomatis==1) {
            $password = $request->nomor_induk;
        } else if ($request->pass_otomatis==0) {
            $password = $request->password;
        };

        $user = $user->create([
            'username' => $request->nomor_induk,
            'password' => bcrypt($password),
            'nama' => $request->nama,
            'nomor_induk' => $request->nomor_induk,
            'email' => $request->email,
            'nomor_whatsapp' => $request->nomor_whatsapp,
            'id_roles' => 2
        ]);

        $response = fractal()
        ->item($user)
        ->transformWith(new InsertDataUserTransformer)
        ->addMeta([
            'token' => $user->api_token,
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
            ->toArray();

    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'message' => 'data sudah terhapus',
        ]);
    }

}
