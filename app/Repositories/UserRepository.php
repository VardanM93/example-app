<?php

namespace App\Repositories;

use App\Models\User;

/**
 * Class UserRepository
 * @package App\Repository
 *
 *
 * @property-read string $name
 * @property-read string $email
 * @property-read string $image
 *
 */

class UserRepository
{

    /**
     * Create User
     * @param string $name
     * @param string $email
     * @param int $password
     * @return User
     */
    public function createEntity(string $name, string $email, int $password):User
    {
        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ]);
    }

    /**
     * Check User Email
     * @param string|null $email
     * @return mixed
     */
    public function checkEntity(?string $email)
    {

        return  User::where('email', $email)->first();
    }




}
