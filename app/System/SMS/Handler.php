<?php

namespace BByer\System\SMS;


use Illuminate\Contracts\Foundation\Application;
use BByer\System\SMS\Contracts\Receiver\ReceiverInterface;
use BByer\System\SMS\Contracts\Sender\SenderInterface;

class Handler
{

    protected $provider = "";

    protected $log;

    private   $sender;

    private   $receiver;

    private   $app;

    public function __construct(Application $application)
    {
        $this->app = $application;

        $this->log = $this->app['log'];
    }


    public function registerReceiver(ReceiverInterface $receiver, $provider = null)
    {
        $provider = $provider ? $provider : $this->provider;

        $this->log->info('REGISTER RECEIVING SMS HANDLER FOR '.$provider.' :'.get_class($receiver));
        $this->receiver[$provider] = $receiver;

        return $this;
    }


    public function registerSender(SenderInterface $sender, $provider = null)
    {
        $provider = $provider ? $provider : $this->provider;
        $this->log->info('REGISTER SENDING SMS HANDLER FOR '.$provider.' :'.get_class($sender));
        $this->sender[$provider] = $sender;

        return $this;
    }

    public function provider($provider)
    {
        $this->provider = $provider;

        return $this;
    }

    public function sender($provider = null)
    {
        $provider = $provider ? $provider : $this->provider;

        return $this->sender[$provider];
    }

    public function receiver($provider = null)
    {
        $provider = $provider ? $provider : $this->provider;

        return $this->receiver[$provider];
    }
}