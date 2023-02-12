<?php

namespace App\Providers;

use App\Models\Campground;
use App\Policies\CampgroundPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Kitar\Dynamodb\Model\AuthUserProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Campground::class => CampgroundPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::provider('dynamodb', static function ($app, array $config) {
            return new AuthUserProvider(
                $app['hash'],
                $config['model'],
                $config['api_token_name'] ?? null,
                $config['api_token_index'] ?? null
            );
        });
    }
}
