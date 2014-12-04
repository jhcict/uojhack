<?php
namespace BByer\System\SMS\Ideamart\Sender\Broker;

use BByer\System\SMS\Contracts\Sender\MessageBrokerInterface;

class MessageBroker implements MessageBrokerInterface
{
    private $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message="")
    {
        return $this->message = $message;
    }
}
