<?php

namespace BByer\System\SMS\Ideamart\Sender;


use BByer\System\Session\Contracts\SessionHandler;
use BByer\System\SMS\Contracts\Sender\AddressBrokerInterface;
use BByer\System\SMS\Contracts\Sender\FormatterInterface;
use BByer\System\SMS\Contracts\Sender\MessageBrokerInterface;
use BByer\System\SMS\Contracts\Sender\ResponseHandlerInterface;
use BByer\System\SMS\Contracts\Sender\SenderInterface;
use BByer\System\SMS\Contracts\Sender\ServiceBrokerInterface;
use BByer\System\SMS\Ideamart\Core;
use BByer\System\SMS\Ideamart\Exceptions\AddressFormatInvalidException;

/**
 * Class Sender
 * @package BByer\System\SMS\Ideamart\Sender
 */
class Sender implements SenderInterface
{

    use  Core;

    protected $addressBroker;

    protected $serviceBroker;

    protected $messageBroker;

    protected $requestFormatter;

    protected $handler;

    protected $session;

    protected $log;

    /**
     * @param \BByer\System\SMS\Contracts\Sender\ServiceBrokerInterface   $serviceBroker
     * @param \BByer\System\SMS\Contracts\Sender\AddressBrokerInterface   $addressBroker
     * @param \BByer\System\SMS\Contracts\Sender\MessageBrokerInterface   $messageBroker
     * @param \BByer\System\SMS\Contracts\Sender\FormatterInterface       $requestFormatter
     * @param \BByer\System\SMS\Contracts\Sender\ResponseHandlerInterface $handler
     * @param \BByer\System\Session\Contracts\SessionHandler              $sessionHandler
     */
    public function __construct(
        ServiceBrokerInterface $serviceBroker,
        AddressBrokerInterface $addressBroker,
        MessageBrokerInterface $messageBroker,
        FormatterInterface $requestFormatter,
        ResponseHandlerInterface $handler,
        SessionHandler $sessionHandler
    )
    {
        $this->session = $sessionHandler;
        $this->serviceBroker = $serviceBroker;
        $this->addressBroker = $addressBroker;
        $this->messageBroker = $messageBroker;
        $this->requestFormatter = $requestFormatter;
        $this->handler = $handler;
        $this->log = app('log');
    }

    public function send()
    {

        if (empty($this->addressBroker->getAddress())) {
            throw new AddressFormatInvalidException();
        } else {
            $jsonStream = $this->requestFormatter
                ->resolveString(
                    $this->messageBroker->getMessage(),
                    $this->addressBroker->getAddress(),
                    $this->serviceBroker
                );

            $response = $this->sendRequest($jsonStream, $this->serviceBroker->server_url);

            return $this->handler->handleResponse($response);
        }

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
