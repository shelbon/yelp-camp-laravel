<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository {

    public function create(array $user):User{
        return User::create([
            'email' => $user['email'],
            'password' => Hash::make($user['password']),
        ]);
    }

    public function exist(string $id){
        return User::where('_id',$id)->exists();
    }
}
