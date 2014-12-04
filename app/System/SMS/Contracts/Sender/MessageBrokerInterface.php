<?php

namespace BByer\System\SMS\Contracts\Sender;

interface MessageBrokerInterface {

    public function getMessage();

    public function setMessage($message);
}
