<?php

namespace BByer\System\USSD\Ideamart\Sender\Contracts;


interface FormatterInterface {

    public function resolveJsonStream($product,$provider);
}