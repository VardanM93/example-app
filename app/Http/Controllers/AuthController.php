<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){

        //fields for register validation

        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);

        //store user in database

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
        ]);

        // result with API Token in Response

        $token = $user->createToken('API Token')->plainTextToken;
        $code = 200;

        $response = [
            'status' => 'success',
            'massage' => 'successful registered',
            'data' => $token,

        ];

        return response()->json([$response],$code);


    }


    public  function  login(Request $request){

        //fields for login validation

        $fields = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|',
        ]);

        // checking email

//        $user = User::where('email', $fields['email'])->first();

        //checking password

//        if (!$user && !Hash::check($fields['password'], $user->password)){
//
//            return response([
//                'message' => 'bad credentials'
//            ],401);
//        }
//        $token = $user->createToken('API Token')->plainTextToken;



        if (!Auth::attempt($fields)){
             return response([
                 'message' => 'bad credentials'
             ],401);
        }


        $token = auth()->user()->createToken('API Token')->plainTextToken;
        $code = 200;

        $response = [
            'status' => 'success',
            'massage' => 'Logged in',
            'data' => $token,

        ];

        return response()->json([$response],$code);
    }

    public function logout(){

        auth()->user()->tokens()->delete();

        return [
            'massage' => 'Logged out'
        ];
    }
}
