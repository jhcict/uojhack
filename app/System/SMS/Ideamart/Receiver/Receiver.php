<?php

namespace BByer\System\SMS\Ideamart\Receiver;

use BByer\System\SMS\Contracts\Receiver\FormatterInterface;
use BByer\System\SMS\Contracts\Receiver\ReceiverInterface;
use BByer\System\SMS\Contracts\Receiver\ValidatorInterface;

class Receiver implements ReceiverInterface
{

    protected $request;
    protected $formatter;
    protected $validator;
    protected $handler;

    public function __construct(
        FormatterInterface $formatter,
        ValidatorInterface $validator
    ) {
        $this->requestFormatter = $formatter;
        $this->requestValidator = $validator;
    }

    public function receive(array $request)
    {
        $validatedRequest = $this->requestValidator->validate($request);

        $this->request = $this->requestFormatter->format($validatedRequest);

        return $this;
    }

    public function getRequest(){
        return $this->request;
    }

    public function getMessage(){
        return $this->request['message'];
    }

    public function getFrom()
    {
        // TODO: Implement getFrom() method.
    }
}
