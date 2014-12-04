<?php

namespace BByer\System\USSD\Ideamart\Sender;

use Illuminate\Contracts\Foundation\Application;
use BByer\System\USSD\Ideamart\Core;
use BByer\System\USSD\Ideamart\Sender\Broker\ServiceBroker;
use BByer\System\USSD\Ideamart\Sender\Contracts\FormatterInterface;

class Sender
{

    use Core;

    protected $app;

    protected $serviceProvider;

    protected $config;

    protected $formatter;

    public function __construct(Application $application,
                                ServiceBroker $broker,
                                FormatterInterface $formatterInterface)
    {
        $this->app = $application;
        $this->config = $this->app->make('config');
        $this->serviceProvider = $broker;
        $this->formatter = $formatterInterface;
    }

    public function send($product)
    {
        $product = $this->formatter->resolveJsonStream($product, $this->serviceProvider);
        return $this->sendRequest($product, $this->serviceProvider->server_url);
    }
}

