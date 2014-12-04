<?php
namespace BByer\System\SMS\Wavecell\Sender;


use BByer\System\SMS\Contracts\Sender\FormatterInterface;

class RequestFormatter implements FormatterInterface
{

    public function resolveString($message, $addresses, $provider)
    {
        $string = "AccountId=$provider->app_id&";
        $string .= "SubAccountId=$provider->sub_app_id&";
        $string .= "Password=$provider->password&";
        $string .= "Destination=$addresses&";
        $string .= "Source=INQURTIME&";
        $string .= "Body=$message&";
        $string .= "Encoding=ASCII&";
        $string .= "ScheduledDateTime=0&";
        $string .= "Encoding=ASCII&";
        $string .= "UMID=";

        return $string;
    }

}
