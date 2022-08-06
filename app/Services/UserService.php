<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;

class UserService
{
    private  UserRepository $userRepository;
    public function __construct(UserRepository $userRepository){
        $this->userRepository=$userRepository;
    }

    public function create(array $validated): User {
       return $this->userRepository->create($validated);
    }
}
