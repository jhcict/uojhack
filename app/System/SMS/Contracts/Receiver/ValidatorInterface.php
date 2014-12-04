<?php namespace BByer\System\SMS\Contracts\Receiver;

interface ValidatorInterface
{

    public function validate(array $request);
}