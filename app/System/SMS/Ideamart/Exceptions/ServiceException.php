<?php

namespace BByer\System\SMS\Ideamart\Exceptions;

class ServiceException extends \Exception
{
    private $statusCode,
    $statusDetail;

    public function __construct($message, $code)
    {
        parent::__construct($message);

        $this->statusCode = $code;
        $this->statusDetail = $message;
    }

    public function getErrorCode()
    {
        return $this->statusCode;
    }

    public function getErrorMessage()
    {
        return $this->statusDetail;
    }
}
