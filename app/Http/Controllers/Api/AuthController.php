<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{

  public function login(Request $req)
  {
    $credentials = $req->only('email', 'password');
    if (! $token = auth()->attempt($credentials)) {
      return response()->json(['error' => 'Unauthorized'], 401);
    }
    return $this->respondWithToken($token);
  }

  public function me()
  {
    return response()->json(auth()->user());
  }

  public function refresh()
  {
    try {
      return $this->respondWithToken(auth()->refresh());
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'Token refresh failed',
        'error' => $e->getMessage(),
      ], 401);
    }
  }

  public function logout()
  {
    auth()->logout();
    return response()->json(['message' => 'Logged out']);
  }

  protected function respondWithToken($token)
  {
    return response()->json([
      'access_token' => $token,
      'token_type'   => 'bearer',
      'expires_in'   => auth()->factory()->getTTL() * 60,
      'user'         => auth()->user(), // ✅ Tambahkan ini
    ]);
  }
}
