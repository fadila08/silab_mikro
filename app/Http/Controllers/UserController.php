<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\ViewUserTransformer;
use Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $user = User::create([
          'username' => $request->nomor_induk,
          'password' => bcrypt($request->nomor_induk),
          'nama' => $request->nama,
          'nomor_induk' => $request->nomor_induk,
          'email' => $request->email,
          'nomor_whatsapp' => $request->nomor_whatsapp,
          'id_roles' => 5
        ]);

        $token = auth()->login($user);

        return $this->respondWithToken($token);
    }

    public function login(Request $request)
    {
      $credentials = $request->only(['username', 'password']);

      $user = User::where('username','=',$credentials['username'])->first();

      if ($user != null) {
        if (in_array($user->api_token, [null,''])) {
          $token = auth()->attempt($credentials);
          // if (!$token = auth()->attempt($credentials)) {
          //   return response()->json(['message' => 'User not found.'], 401);
          // }
          $user->update([
            'api_token' => $token
          ]);
        }
        else {
          $token = $user->api_token;
        }
      }

      // $user = User::find($request->user()->id);

      
      return $this->respondWithToken($token,$user);
    }

    protected function respondWithToken($token,$user)
    {
      return response()->json([
        'user' => $user,
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => auth()->factory()->getTTL() * 60
      ]);
    }

    public function getAuthenticatedUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                    return response()->json(['user_not_found'], 404);
            }
        }
        catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        }
        catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        }
        catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }

        // return response()->json($user);
        return fractal()
            ->item($user)
            ->transformWith(new ViewUserTransformer)
            ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
            ->toArray();
    }
}
