<?php
/**
 * Copyright MyTh
 * Website: https://4MyTh.com
 * Email: mythpe@gmail.com
 * Copyright © 2006-2020 MyTh All rights reserved.
 */

namespace Myth\Support\ArabicNumbers\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Myth\Support\ArabicNumbers\Middlewares\NumbersArabicToEnglishMiddleware;

/**
 * Class ArabicNumbersProvider
 * @package Myth\Support\ArabicNumbers\Providers
 */
class ArabicNumbersProvider extends ServiceProvider{

    /** @var array Config data */
    protected $configData = [
        'path' => __DIR__.'/../../config/arabic-numbers.php',
        'key'  => "arabic-numbers",
    ];

    /**
     * Register services.
     * @return void
     */
    public function register(){
        $this->mergeConfigFrom($this->configData['path'], $this->configData['key']);
    }

    /**
     * Bootstrap services.
     * @param Router $router
     * @return void
     */
    public function boot(Router $router){
        $this->publishes([$this->configData['path'] => config_path("{$this->configData['key']}.php")], 'config');
        $config = $this->app['config']->get($this->configData['key']);
        $router->aliasMiddleware(
            "myth.{$config['middleware_name']}",
            NumbersArabicToEnglishMiddleware::class
        );
    }

    /**
     * @return array
     */
    public function provides(){
        return [$this->configData['key']];
    }
}
