<?php

namespace BByer\System\SMS\Wavecell\Sender;

use BByer\System\SMS\Contracts\Sender\ResponseHandlerInterface;
use BByer\System\SMS\Ideamart\Exceptions\ServiceException;

class ResponseHandler implements ResponseHandlerInterface
{


    public function __construct()
    {
    }

    public function handleResponse($response)
    {
        return true;
    }

}
