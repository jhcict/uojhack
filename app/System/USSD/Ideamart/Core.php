<?php

namespace BByer\System\USSD\Ideamart;


trait Core
{

    /**
     * @param $jsonResponse
     * @param $url
     */
    public function sendRequest($jsonResponse, $url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array ('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonResponse);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        app('log')->info("SENDING REQUEST :" . $jsonResponse);
        app('log')->info("SENDING REQUEST TO URL:" . $url);
        app('log')->info("RECEIVED RESPONSE :" . $response);

        return $response;
    }

}