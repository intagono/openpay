<?php namespace Intagono\Openpay;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Intagono\Openpay\Openpay;
use Openpay as OpenpayCore;

class OpenpayServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Intagono\Openpay\Openpay', function($app) {
            $productionMode = config('openpay.production_mode');
            $merchantId = config('openpay.merchant_id');
            $privayeKey = config('openpay.private_key');

            $openpayCore = OpenpayCore::getInstance($merchantId, $privayeKey);

            if ($productionMode) {
                OpenpayCore::setProductionMode(true);
            }

            return new Openpay($openpayCore);
        });

        $this->app->bind('openpay', 'Intagono\Openpay\Openpay');

        $this->mergeConfigFrom(
            __DIR__ . '/config/openpay.php', 'openpay'
        );    }

    /**
     * Publish the plugin configuration.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/openpay.php' => config_path('openpay.php')
        ]);

        $this->publishes([
            __DIR__.'/migrations/' => database_path('migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__.'/models/' => app_path('models')
        ], 'migrations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'openpay',
            'Intagono\Openpay\Openpay',
        ];
    }

}
