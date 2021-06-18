<?php

namespace Agenciafmd\Zapier\Providers;

use Illuminate\Support\ServiceProvider;

class ZapierServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // 
    }

    public function register()
    {
        $this->loadConfigs();
    }

    protected function loadConfigs()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-zapier.php', 'laravel-zapier');
    }
}
