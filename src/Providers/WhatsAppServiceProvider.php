<?php

namespace Emmaogunwobi\WhatsappApi\Providers;

use Illuminate\Support\ServiceProvider;
use Emmaogunwobi\WhatsappApi\Services\WhatsAppService;

class WhatsAppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(WhatsAppService::class, function () {
            return new WhatsAppService();
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../Config/whatsapp.php' => config_path('whatsapp.php'),
        ], 'config');
    }
}