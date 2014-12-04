<?php
namespace BByer\System\SMS\Wavecell\Sender;

use BByer\System\Session\Contracts\SessionHandler;
use BByer\System\SMS\Contracts\Sender\AddressBrokerInterface;
use BByer\System\SMS\Contracts\Sender\FormatterInterface;
use BByer\System\SMS\Contracts\Sender\MessageBrokerInterface;
use BByer\System\SMS\Contracts\Sender\ResponseHandlerInterface;
use BByer\System\SMS\Contracts\Sender\SenderInterface;
use BByer\System\SMS\Contracts\Sender\ServiceBrokerInterface;
use BByer\System\SMS\Ideamart\Exceptions\AddressFormatInvalidException;
use BByer\System\SMS\Wavecell\Core;

class Sender implements SenderInterface
{

    use Core;

    protected $session;

    protected $addressBroker;

    protected $serviceBroker;

    protected $messageBroker;

    protected $handler;

    protected $log;

    protected $requestFormatter;

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

        // TODO: Implement __construct() method.
    }

    /**
     * @return mixed
     * @throws \BByer\System\SMS\Ideamart\Exceptions\AddressFormatInvalidException
     */
    public function send()
    {

        if (empty($this->addressBroker->getAddress())) {
            throw new AddressFormatInvalidException();
        } else {
            foreach ( $this->addressBroker->getAddress() as $address ) {

                $string = $this->requestFormatter
                    ->resolveString(
                        $this->messageBroker->getMessage(),
                        $address,
                        $this->serviceBroker
                    );

                $response = $this->sendRequest($string, $this->serviceBroker->server_url);
                $this->handler->handleResponse($response);
            }

        }
        // TODO: Implement send() method.
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
        // TODO: Implement refresh() method.
    }
}