<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\User;


class UserRepository
{

    /**
     * @param string|null $name
     * @param string|null $email
     * @param int|null $password
     * @return User
     */
    public function createEntity(?string $name, ?string $email, ?int $password):User
    {
        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ]);
    }

    /**
     * @param string|null $email
     * @return mixed
     */
    public function checkEntity(?string $email)
    {

        return  User::where('email', $email)->first();
    }




}
