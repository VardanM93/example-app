<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\RegisterFormRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterFormRequest $request){


        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);


        $token = $user->createToken('API Token')->plainTextToken;
        $code = 200;

        $response = [
            'status' => 'success',
            'massage' => 'successful registered',
            'data' => $token,

        ];

        return response()->json([$response],$code);

    }


    public  function  login(LoginFormRequest $request){

       $user = User::where('email', $request['email'])->first();


        if (!$user || !Hash::check($request['password'], $user->password)){

            return response([
                'message' => 'bad credentials'
            ],401);
        }



        $token = $user->createToken('API Token')->plainTextToken;
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
