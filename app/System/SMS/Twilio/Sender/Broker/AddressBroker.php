<?php

namespace BByer\System\SMS\Twilio\Sender\Broker;

use BByer\System\SMS\Contracts\Sender\AddressBrokerInterface;

class AddressBroker implements AddressBrokerInterface
{

    protected $address;

    public function __construct(array $address = null)
    {
        $this->address = $address;
    }

    public function addAddress($address)
    {
        $this->address = $address;
    }

    public function getAddress()
    {
        return $this->address;
    }
}
