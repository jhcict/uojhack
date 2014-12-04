<?php

namespace BByer\System\SMS\Wavecell\Sender\Broker;
use BByer\System\SMS\Contracts\Sender\AddressBrokerInterface;

class AddressBroker implements AddressBrokerInterface
{
    protected $addresses;

    public function __construct(array $addresses=null)
    {
        $this->addresses = $addresses;
    }
    public function addAddress($addresses)
    {
        if (is_array($addresses)) {
            $this->addresses = array_merge($this->addresses, $addresses);
        } else {
            $this->addresses[] = $addresses;
        }

        return true;
    }

    public function getAddress()
    {
        return $this->addresses;
    }
 }
