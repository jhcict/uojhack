<?php


namespace BByer\System\SMS\Contracts;


use BByer\System\SMS\Contracts\Receiver\ReceiverInterface;
use BByer\System\SMS\Contracts\Sender\SenderInterface;

interface HandlerInterface {

    public function __construct(
        SenderInterface $sender,
        ReceiverInterface $receiver
    );

    public function sender();

    public function receiver();

}