<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      try {
        $userReq = $request->only('name', 'email', 'password', 'password_confirmation');

        if ($userReq['password'] === $userReq['password_confirmation']) {
          $id = User::insertGetId([
            'name' => $userReq['name'],
            'email' => $userReq['email'],
            'password' => Hash::make($userReq['password'])
          ]);
        }

        $data = [
          'id' => $id,
          'name' => $userReq['name'],
          'email' => $userReq['email'],
          'meta' => json_decode ("{}")
        ];

        return compact('data');
      } catch (Exception $e) {
        return response()->json([
          'errors' => [
            'message' => 'Operation Failed',
            'errors' => [
              'generic' => 'Something went wrong'
            ]
          ]], 500);
      }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function read(User $user)
    {
      //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
      //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
