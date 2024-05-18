<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Administrator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function admins() {
        $admins = Administrator::all()->map(function($admin) {
            return [
                'username' => $admin->username,
                'last_login_at' => $admin->last_login_at,
                'created_at' => $admin->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $admin->updated_at->format('Y-m-d H:i:s'),
            ];
        });

        return response()->json([
            'total_elements' => $admins->count(),
            'Content' => $admins
        ], 200);
    }

    public function users(Request $request){
            $validated = Validator::make($request->all(),[
                'username' => 'required|unique:users|min:4|max:60',
                'password' => 'required|min:5|max:10|'
            ]);

            if ($validated->fails()) {
                return response()->json([
                    'status' => 'invalid',
                    'message'=> $validated->errors()
                ],400);
            }

            $request['password'] = Hash::make($request->password);


            $user = User::create($request->all());
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status'    => 'success',
                'token'     => $token
            ],201);
        }

        public function getusers() {

            $users = User::all()->map(function($users) {
                return [
                    'username' => $users->username,
                    'last_login_at' => $users->last_login_at,
                    'created_at' => $users->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $users->updated_at->format('Y-m-d H:i:s'),
                ];
            });

            return response()->json([
                'total_elements' => $users->count(),
                'Content' => $users
            ], 200);

        }

        public function edituser(Request $request, $id)
        {
        $user = User::findOrFail($id);

        $validated = Validator::make($request->all(),[
            'username' => 'required|unique:users|min:4|max:60',
            'password' => 'required|min:5|max:10|'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => 'invalid',
                'message'=> $validated->errors()
            ],400);
        }

        $request['password'] = Hash::make($request->password);
        $user->update($request->all());

        return response()->json([
            'status' => 'success',
            'username' => $user->username
        ],201);
    }

    public function deleteuser($id)
{
    try {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json([], 204);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status'=> 'not-found',
                'message' => 'User not found'
            ], 403);
        }
}
}
