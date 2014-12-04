<?php

namespace BByer\System\SMS\Contracts\Receiver;

interface ReceiverInterface
{
    public function __construct(
        FormatterInterface $formatter,
        ValidatorInterface $validator);

    public function receive(array $request);

    public function getRequest();

    public function getMessage();

    public function getFrom();
}