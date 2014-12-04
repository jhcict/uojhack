<?php

namespace BByer\System\SMS\Contracts\Sender;


interface AddressBrokerInterface {

    public function getAddress();

    public function addAddress($add);

}