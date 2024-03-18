<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Kreait\Firebase\Factory;

class FirebaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('firebase', function ($app) {
            $firebaseConfig = config('firebase');
            return (new Factory)
                ->withServiceAccount([
                    'type' => $firebaseConfig['type'],
                    'project_id' => $firebaseConfig['project_id'],
                    'private_key_id' => $firebaseConfig['private_key_id'],
                    'private_key' => $firebaseConfig['private_key'],
                    'client_email' => $firebaseConfig['client_email'],
                    'client_id' => $firebaseConfig['client_id'],
                    'auth_uri' => $firebaseConfig['auth_uri'],
                    'token_uri' => $firebaseConfig['token_uri'],
                    'auth_provider_x509_cert_url' => $firebaseConfig['auth_provider_x509_cert_url'],
                    'client_x509_cert_url' => $firebaseConfig['client_x509_cert_url'],
                ])
                ->create();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
