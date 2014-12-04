<?php namespace BByer\System\SMS\Wavecell;

trait Core
{

    /**
     * @param $responseString
     * @param $url
     *
     * @return mixed
     * @internal param $jsonResponse
     */
    public function sendRequest($responseString, $url)
    {
        $ch = curl_init($url);

        $f = fopen('../storage/logs/request.txt', 'w');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt($ch, CURLOPT_GET, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $responseString);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array ('Content-Type: application/x-www-form-urlencoded'));
        $headers  =  array( "Accept:" );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_STDERR, $f);
        $response = curl_exec($ch);
        fclose($f);
        curl_close($ch);

//        $this->log->info("SENDING HEADER:" . $f);
        $this->log->info("SENDING REQUEST :" . $responseString);
        $this->log->info("SENDING REQUEST TO URL:" . $url);
        $this->log->info("RECEIVED RESPONSE :" . $response);

        return $response;
    }
}
