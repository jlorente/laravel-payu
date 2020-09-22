<?php

/**
 * Part of the PayU Laravel package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    PayU Laravel
 * @version    1.0.0
 * @author     Jose Lorente
 * @license    BSD License (3-clause)
 * @copyright  (c) 2019, Jose Lorente
 */

namespace Jlorente\Laravel\PayU;

use Jlorente\Laravel\PayU\Models\PayU;
use Illuminate\Support\ServiceProvider;

/**
 * Class PayUServiceProvider.
 * 
 * @author Jose Lorente <jose.lorente.martin@gmail.com>
 */
class PayUServiceProvider extends ServiceProvider
{

    /**
     * @inheritdoc
     */
    protected $defer = true;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/payu.php' => config_path('payu.php'),
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function register()
    {
        $this->registerPayU();
    }

    /**
     * {@inheritDoc}
     */
    public function provides()
    {
        return [
            'payu'
            , PayU::class
        ];
    }

    /**
     * Register the PayU API class.
     *
     * @return void
     */
    protected function registerPayU()
    {
        $this->app->singleton('payu', function ($app) {
            $config = $app['config']->get('payu');
            return new PayU(
                    isset($config['api_key']) ? $config['api_key'] : null
                    , isset($config['api_login']) ? $config['api_login'] : null
                    , isset($config['merchant_id']) ? $config['merchant_id'] : null
                    , isset($config['language']) ? $config['language'] : null
                    , isset($config['is_test']) ? $config['is_test'] : null
            );
        });

        $this->app->alias('payu', PayU::class);
    }

}
