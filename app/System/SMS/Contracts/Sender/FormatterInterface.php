<?php

namespace BByer\System\SMS\Contracts\Sender;

interface FormatterInterface
{

    public function resolveString($getMessage, $getAddress, $serviceBroker);
}
