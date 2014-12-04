<?php

namespace BByer\System\SMS\Ideamart\Sender;

use BByer\System\SMS\Contracts\Sender\ResponseHandlerInterface;
use BByer\System\SMS\Ideamart\Exceptions\ServiceException;

class ResponseHandler implements  ResponseHandlerInterface
{


    public function __construct()
    {
    }

    public function handleResponse($jsonResponse)
    {
        $jsonResponse = json_decode($jsonResponse);
        $statusCode = $jsonResponse->statusCode;
        $statusDetail = $jsonResponse->statusDetail;

        if (empty($jsonResponse)) {
            throw new ServiceException('Invalid server URL', '500');
        } elseif (strcmp($statusCode, 'S1000') == 0) {
            return true;
        } else {
            throw new ServiceException($statusDetail, $statusCode);
        }
    }

}
