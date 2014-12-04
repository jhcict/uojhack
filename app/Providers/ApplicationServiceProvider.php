<?php

namespace BByer\Providers;


use Illuminate\Support\ServiceProvider;

class ApplicationServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // TODO: Implement register() method.

        app()->bind('BByer\Source\Applications\ApplicationRepository',
                    'BByer\Source\Applications\MySQLApplicationRepository');
    }
}