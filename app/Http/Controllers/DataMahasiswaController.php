<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\InsertDataUserTransformer;
use App\Transformers\UserTransformer;
use App\Transformers\ViewUserTransformer;
use App\Imports\MahasiswaImport;
use Validator;
use Auth;
use Excel;
use App\User;

class DataMahasiswaController extends Controller
{
  protected function validator(array $data)
  {
    return Validator::make($data, [
      'nomor_induk' => 'required|max:20|unique:users',
      'nama' => 'required|string|max:50'
    ]);
  }

  public function index(User $user)
  {
    $user = $user->where('id_roles', '=', 5)->get(); 

    return fractal()
      ->collection($user)
      ->transformWith(new ViewUserTransformer)
      // ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
      ->toArray();
  }

  public function show(User $user)
  {
    return fractal()
      ->item($user)
      ->transformWith(new UserTransformer)
      // ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
      ->toArray();
  }
  
  public function store(Request $request, User $user)
  {
    //   return response()->json($request->all());
    $this->validator($request->all())->validate();

    $user = $user->create([
      'username' => $request->nomor_induk,
      'password' => bcrypt($request->nomor_induk),
      'nama' => $request->nama,
      'nomor_induk' => $request->nomor_induk,
      'email' => $request->email,
      'nomor_whatsapp' => $request->nomor_whatsapp,
      'id_roles' => 5
    ]);

    $response = fractal()
    ->item($user)
    ->transformWith(new InsertDataUserTransformer)
    // ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
    ->addMeta([
      'token' => auth()->login($user),
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
      // ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
      ->toArray();
  }

  public function destroy(User $user)
  {
    $user->delete();

    return response()->json([
      'message' => 'data sudah terhapus',
    ]);
  }

  public function import(Request $request)
  {
    $datas = Excel::import(new MahasiswaImport, $request->file('file'));
    return response()->json([
      'message' => 'yay! :)'
    ]);
  }

}
