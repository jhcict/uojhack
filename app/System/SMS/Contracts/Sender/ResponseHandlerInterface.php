<?php

namespace BByer\System\SMS\Contracts\Sender;


interface ResponseHandlerInterface {

    public function handleResponse($response);
}