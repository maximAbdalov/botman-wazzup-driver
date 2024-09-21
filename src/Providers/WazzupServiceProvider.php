<?php

namespace BotMan\Drivers\WazzupDriver\Providers;

use BotMan\Drivers\WazzupDriver\WhatsAppDriver;
use Illuminate\Support\ServiceProvider;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\WazzupDriver;
use BotMan\Studio\Providers\StudioServiceProvider;

class WazzupServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        if (! $this->isRunningInBotManStudio()) {
            $this->loadDrivers();

            $this->publishes([
                __DIR__.'/../../stubs/whatsapp.php' => config_path('botman/whatsapp.php'),
            ]);

            $this->mergeConfigFrom(__DIR__.'/../../stubs/whatsapp.php', 'botman.whatsapp');
        }
    }

    /**
     * Load BotMan drivers.
     */
    protected function loadDrivers()
    {
        DriverManager::loadDriver(WhatsAppDriver::class);
    }

    /**
     * @return bool
     */
    protected function isRunningInBotManStudio()
    {
        return class_exists(StudioServiceProvider::class);
    }
}
