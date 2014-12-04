<?php


namespace BByer\System\SMS\Contracts\Sender;


use BByer\System\Session\Contracts\SessionHandler;

interface SenderInterface
{

    public function __construct(
        ServiceBrokerInterface $serviceBroker,
        AddressBrokerInterface $addressBroker,
        MessageBrokerInterface $messageBroker,
        FormatterInterface $requestFormatter,
        ResponseHandlerInterface $handler,
        SessionHandler $sessionHandler
    );

    public function send();

    public function addAddress($address);

    public function setMessage($message);

    public function refresh($appId);
}