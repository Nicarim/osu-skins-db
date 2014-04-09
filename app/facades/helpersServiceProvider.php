<?php

use Illuminate\Support\ServiceProvider;

class helpersServiceProvider extends ServiceProvider {

    public function register()
    {
        // Register 'underlyingclass' instance container to our UnderlyingClass object
        $this->app['Helpers'] = $this->app->share(function($app)
            {
                return new facades\helpers\helpers;
            });

        // Shortcut so developers don't need to add an Alias in app/config/app.php
        $this->app->booting(function()
            {
                $loader = \Illuminate\Foundation\AliasLoader::getInstance();
                $loader->alias('Helpers', 'facades\helpers\helpers');
            });
    }

}