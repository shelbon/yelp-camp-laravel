<?php

namespace App\Services;

use Illuminate\Support\Facades\URL;

class GenerateTemporarySignedRouteService
{
    public function __construct()
    {
    }

    public function generate($route, array $parameters): string
    {
        return URL::temporarySignedRoute($route,now()->addMinute(10),$parameters);
    }
}
