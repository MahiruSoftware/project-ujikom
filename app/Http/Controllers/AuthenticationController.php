<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Developer;
use Illuminate\Http\Request;
use App\Models\Administrator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
    public function signup(Request $request) {
        $validated = Validator::make($request->all(),[
            'username' => 'required|unique:users|min:4|max:60',
            'password' => 'required|min:5|max:10|'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'invalid field',
                'errors'=> $validated->errors()
            ]);
        }


    $request['password'] = Hash::make($request->password);

    $user = User::create($request->all());
    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'status'    => 'success',
        'token'     => $token
    ],201);

    }

    public function signin(Request $request) {
        $validated = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => 'invalid',
                'message' => $validated->errors()
            ], 401);
        }

        $user = $this->findUser($request->username);

        if ($user && Hash::check($request->password, $user->password)) {
            $user->updateLastLogin();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'token' => $token
            ],200);
        }

        return response()->json([
            'status' => 'invalid',
            'message' => 'wrong Username or Password'
        ], 401);
    }

    private function findUser($username) {
        $user = Administrator::where('username', $username)->first();
        if ($user) {
            return $user;
        }

        $user = Developer::where('username', $username)->first();
        if ($user) {
            return $user;
        }

        return User::where('username', $username)->first();
    }

    public function signout() {

        Auth::user()->tokens()->delete();

        return response()->json([
            'status' => 'success'
        ],200);
    }
}
