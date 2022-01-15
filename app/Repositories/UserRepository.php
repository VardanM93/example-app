<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{


    public function createEntity(?string $name, ?string $email, ?int $password):User
    {
        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ]);
    }

    public function checkEntity(?string $email)
    {

        return  User::where('email', $email)->first();
    }
//
//    public function createUserToken()
//    {
//        // TODO: Implement createUserToken() method.
//    }
}
