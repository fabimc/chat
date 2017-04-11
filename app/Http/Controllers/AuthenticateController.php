<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthenticateController extends Controller
{
  //public function authenticate(Request $request)
  public function login(Request $request)
  {
    // grab credentials from the request
    $credentials = $request->only('email', 'password');

    try {
      // grab the user data
      $user = User::where('email', $credentials['email'])->first();

      // attempt to verify the credentials and create a token for the user
      if (is_null($user) || ! ( $token = JWTAuth::attempt($credentials) ) ) {
          return response()->json(['error' => 'invalid_credentials'], 401);
      }
    } catch (JWTException $e) {
        // something went wrong whilst attempting to encode the token
        return response()->json(['error' => 'could_not_create_token'], 500);
    }

    $data = [
      'id' => $user->id,
      'name' => $user->name,
      'email' => $user->email,
      'meta' => json_decode ("{}")
    ];

    // all good so return the token
    return response()
      ->json(compact('data'))
      ->withHeaders([
          'Authorization' => 'Bearer ' . $token
      ]);
  }

    public function logout(Request $request)
    {
      JWTAuth::invalidate(JWTAuth::getToken());
      return response('', 204);
    }

    public function user() {
      $user = JWTAuth::toUser(JWTAuth::getToken());

      $data = [
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'meta' => json_decode ("{}")
      ];

      return compact('data');
    }

    public function update(Request $request) {
      $user = JWTAuth::toUser(JWTAuth::getToken());

      $userReq = $request->only('name', 'email', 'password', 'password_confirmation');

      if (is_null($userReq['name'])) {
        $userReq['name'] = $user->name;
      }
      if ($user->email === $userReq['email']
        && $userReq['password'] === $userReq['password_confirmation']) {
        $update = User::where('email', '=', $userReq['email'])
          ->update([
            'name' => $userReq['name'],
            'password' => Hash::make($userReq['password'])
          ]);
      }

      if ($update) {
        $data = [
          'id' => $user->id,
          'name' => $userReq['name'],
          'email' => $userReq['email'],
          'meta' => json_decode ("{}")
        ];

        return compact('data');

      } else {

        return response()->json([
          'errors' => [
            'message' => 'Operation Failed',
            'errors' => [
              'generic' => 'Something went wrong'
            ]
          ]], 500);
      }

    }
}
