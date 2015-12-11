<?php namespace Intagono\Openpay;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

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

            $openpayCore = \Openpay::getInstance($merchantId, $privayeKey);

            if ($productionMode) {
                \Openpay::setProductionMode(true);
            }

            return new \Intagono\Openpay\Openpay($openpayCore);
        });

        $this->app->bind('openpay', 'Intagono\Openpay\Openpay');

        $this->mergeConfigFrom(
            __DIR__ . '/config/openpay.php', 'openpay'
        );

        AliasLoader::getInstance()->alias(
            'IntagonoOpenpay',
            'Intagono\Openpay\OpenpayFacade'
        );
    }

    /**
     * Publish the plugin configuration.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/openpay.php' => config_path('openpay.php')
        ]);
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
