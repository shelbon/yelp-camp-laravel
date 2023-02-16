<?php

namespace App\Cognito\Providers;


use App\Cognito\CognitoClient;
use App\Cognito\Guard\CognitoGuard;
use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class CognitoAuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->singleton(CognitoClient::class, function (Application $app) {
            $config = [
                'credentials' => config('cognito.credentials'),
                'region' => config('cognito.region'),
                'version' => config('cognito.version'),
                'endpoint'=>config('cognito.endpoint'),
            ];

            return new CognitoClient(
                new CognitoIdentityProviderClient($config),
                config('cognito.app_client_id'),
                config('cognito.app_client_secret'),
                config('cognito.user_pool_id')
            );
        });
        $this->app['auth']->extend('cognito', function (Application $app, $name, array $config) {
            $guard = new CognitoGuard(
                $name,
                $client = $app->make(CognitoClient::class),
                $app['auth']->createUserProvider($config['provider']),
                $app['session.store'],
                $app['request']
            );

            $guard->setCookieJar($this->app['cookie']);
            $guard->setDispatcher($this->app['events']);
            $guard->setRequest($this->app->refresh('request', $guard, 'setRequest'));

            return $guard;
        });

    }
}
