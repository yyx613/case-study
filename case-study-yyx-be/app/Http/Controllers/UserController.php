<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function autoLogin(Request $request) {
        $userId = $request->input('id');
        
        $user = DB::table('users')->select(
            'id', 'first_name', 'last_name', 'email'
        )->where('id', $userId)->first();
        if($user != null) {
            return response()->json([
                'user' => $user
            ], Response::HTTP_OK);
        } else {
            return response()->json([], Response::HTTP_BAD_REQUEST);
        }
    }

    public function login(Request $request) {
        // Validate data
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }
        // fetch user info from db
        $requestedUser = DB::table('users')->select(
            'id', 'first_name', 'password', 'last_name', 'email'
        )->where('email', $request->input('email'))->first();

        if($requestedUser == null) {
            return response()->json([
                'email' => ['email doesnt exists']
            ], Response::HTTP_BAD_REQUEST);
        } else if($request->input('password') != $requestedUser->password) {
            return response()->json([
                'password' => ['invalid password']
            ], Response::HTTP_BAD_REQUEST);
        }

        unset($requestedUser->password);

        return response()->json([
            'user' => $requestedUser
        ], Response::HTTP_OK);
    }

    public function register(Request $request) {
        // Validate data
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed'],
            'password_confirmation' => ['required'],
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }
        // Insert into db
        DB::table('users')->insert([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user = DB::table('users')->where('email', $request->input('email'))->first();

        return response()->json([
            'user' => $user
        ], Response::HTTP_OK);
    }
}
