<?php

namespace BByer\System\SMS\Twilio\Sender;


use BByer\System\Session\Contracts\SessionHandler;
use BByer\System\SMS\Contracts\Sender\AddressBrokerInterface;
use BByer\System\SMS\Contracts\Sender\FormatterInterface;
use BByer\System\SMS\Contracts\Sender\MessageBrokerInterface;
use BByer\System\SMS\Contracts\Sender\ResponseHandlerInterface;
use BByer\System\SMS\Contracts\Sender\SenderInterface;
use BByer\System\SMS\Contracts\Sender\ServiceBrokerInterface;
use BByer\System\SMS\Twilio\Core;

class Sender extends Core implements SenderInterface
{

    protected $addressBroker;

    protected $messageBroker;

    protected $twilio;

    public function __construct(
        ServiceBrokerInterface $serviceBroker,
        AddressBrokerInterface $addressBroker,
        MessageBrokerInterface $messageBroker,
        FormatterInterface $requestFormatter,
        ResponseHandlerInterface $handler,
        SessionHandler $sessionHandler
    )
    {
        $this->serviceBroker = $serviceBroker;
        $this->addressBroker = $addressBroker;
        $this->messageBroker = $messageBroker;
        $this->requestFormatter = $requestFormatter;
        $this->handler = $handler;
    }

    public function send()
    {
        if (empty($this->addressBroker->getAddress())) {
            throw new AddressFormatInvalidException();
        }
        $this->twilio = $this->twilio($this->serviceBroker);
        $this->twilio->account->messages->sendMessage(
            $this->serviceBroker->from,
            $this->addressBroker->getAddress(),
            $this->messageBroker->getMessage()
        );
    }

    public function addAddress($address)
    {
        if (is_array($address)) {
            foreach ( $address as $add ) {
                $this->addressBroker->addAddress($add);
            }

            return $this;
        }
        $this->addressBroker->addAddress($address);

        return $this;
    }

    public function setMessage($message)
    {
        $this->messageBroker->setMessage($message);

        return $this;
    }


    public function refresh($appId)
    {

        $this->serviceBroker->refresh($appId);

        return $this;
    }
}