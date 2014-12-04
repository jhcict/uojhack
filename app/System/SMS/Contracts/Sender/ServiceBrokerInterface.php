<?php

namespace BByer\System\SMS\Contracts\Sender;

interface ServiceBrokerInterface {
    public function __get($name);
    public function __set($name,$value);

    public function refresh($appId);
}