<?php

namespace BByer\System\USSD;


use Illuminate\Contracts\Foundation\Application;

class Handler {

    protected $provider = "";

    private   $handler;

    private   $app;

    public function __construct(Application $application)
    {
        $this->app = $application;
    }


    public function registerHandler($handler, $provider = null)
    {
        $provider = $provider ? $provider : $this->provider;
        $this->handler[$provider] = $handler;

        return $this;
    }


    public function provider($provider)
    {
        $this->provider = $provider;

        return $this;
    }

    public function handler($provider = null)
    {
        $provider = $provider ? $provider : $this->provider;

        return $this->handler[$provider];
    }
}