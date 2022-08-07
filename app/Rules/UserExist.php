<?php

namespace App\Rules;

use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Contracts\Validation\Rule;

class UserExist implements Rule
{
    private  UserService $userService;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct( UserService $userService){
        $this->userService=$userService;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool{
       return $this->userService->exist($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return  'The user doesn\'t exist';
    }
}
