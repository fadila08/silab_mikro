<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\InsertDataUserTransformer;
use App\Transformers\UserTransformer;
use App\Transformers\ViewUserTransformer;
use App\Imports\MahasiswaImport;
use Validator;
use Auth;
use App\User;
use App\Dosbim;

class DataDosenController extends Controller
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
    $user = $user->where('id_roles', '=', 4)->get(); 

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
    //   return response()->json($request->all());
    $this->validator($request->all())->validate();
    $ni = $request->nomor_induk;

    $user = $user->create([
      'username' => $ni,
      'password' => bcrypt($ni),
      'nama' => $request->nama,
      'nomor_induk' => $ni,
      'email' => $request->email,
      'nomor_whatsapp' => $request->nomor_whatsapp,
      'id_roles' => 4,
      'kode' => $request->kode
    ]);

    $response = fractal()
      ->item($user)
      ->transformWith(new InsertDataUserTransformer)
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
      ->toArray();
  }

  public function destroy(User $user)
  {
    $dosbim = Dosbim::where('id_dosbim',$user->id)->get();
    foreach ($dosbim as $i) {
        $update = Dosbim::find($i->id);
        $update->id_dosbim = null;
        $update->update();
    }
    $user->delete();

    return response()->json([
      'message' => 'data sudah terhapus',
    ]);
  }

}
