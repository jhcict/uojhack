<?php

namespace BByer\Providers\Ideamart;


use Illuminate\Support\ServiceProvider;
use BByer\System\USSD\Ideamart\Sender\Broker\ServiceBroker;

class USSDServiceProvider extends ServiceProvider
{


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind('BByer\System\USSD\Ideamart\Sender\Contracts\FormatterInterface',
                         'BByer\System\USSD\Ideamart\Sender\RequestFormatter');
        $this->app->singleton(ServiceBroker::class, function () {
            return new ServiceBroker("", "", "");
        });
        $this->app->bind('ideamart_ussd', 'BByer\System\USSD\Ideamart\Handler');
    }
}
