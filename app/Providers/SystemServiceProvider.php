<?php namespace BByer\Providers;

use Illuminate\Support\ServiceProvider;
use BByer\System\SMS\Handler;

class SystemServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton('BByer\System\Session\Contracts\SessionHandler',
                         'BByer\System\Session\DatabaseSessionHandler');
        $this->app->bind('BByer\System\ConfigLoader\Contracts\ConfigLoader',
                         'BByer\System\ConfigLoader\MySQLConfigLoader');
        $this->app->singleton('sms', function () {
            return new Handler(app());
        });
        $this->app->singleton('ussd', function () {
            return new Handler(app());
        });
        $this->app->singleton('subscription', function () {
            return new Handler(app());
        });
    }


    public function provides()
    {
        return ['sms', 'ussd', 'subscription'];
    }

}
