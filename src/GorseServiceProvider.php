<?php

namespace Erfansahaf\GorseLaravel;


use Erfansahaf\GorseLaravel\Exceptions\GorseException;
use Illuminate\Support\ServiceProvider;

class GorseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/gorse.php', 'gorse');

        $this->app->bind(GorseClient::class, function ($app) {
            $endpoint = config('gorse.endpoint');
            if (!$endpoint) {
                throw GorseException::missingEndpoint();
            }
            
            return new GorseClient($endpoint, config('gorse.api_key'), config('gorse.options'));
        });
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/gorse.php' => config_path('gorse.php'),
            ], 'config');
        }
    }
}
