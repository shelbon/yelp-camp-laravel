<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class UserRepository
{

    public function create(array $user): User
    {
        $user = new User([
            "id" => Uuid::uuid4()->toString(),
            'email' => $user['email'],
            'password' => Hash::make($user['password']),
        ]);
        $user->save();
        return $user;
    }

    public function exist(string $id)
    {
        $user = User::filter('id', "=", $id)
            ->scan()
            ->first();
        return $user !== null;
    }
}
