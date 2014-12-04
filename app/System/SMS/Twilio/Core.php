<?php

namespace BByer\System\SMS\Twilio;


use BByer\System\SMS\Contracts\Sender\ServiceBrokerInterface;

class Core
{

    public function __construct()
    {
    }

    public function twilio(ServiceBrokerInterface $serviceBrokerInterface)
    {
        return new \Services_Twilio($serviceBrokerInterface->app_id, $serviceBrokerInterface->app_secret);
    }
}