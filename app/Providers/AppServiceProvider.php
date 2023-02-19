<?php

namespace App\Providers;

use App\S3\S3Uploader;
use Aws\S3\S3ClientInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(S3Uploader::class, static function ($app) {
            return new S3Uploader(
                 $app->make('aws')->createClient('s3'),
            );
        });
        $this->app->bind(S3ClientInterface::class, static function ($app) {
            return $app->make('aws')->createClient('s3');
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
