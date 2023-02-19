<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;

class GenerateEmailVerificationRouteService
{
    public function __construct(private GenerateTemporarySignedRouteService $generateTemporarySignedRoute)
    {
    }

    public function generate(string $email): string
    {
        return $this->generateTemporarySignedRoute->generate("verification.show", ["email" => Hash::make($email)]);
    }
}
