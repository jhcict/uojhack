<?php
namespace BByer\System\SMS\Ideamart\Sender;


use BByer\System\SMS\Contracts\Sender\FormatterInterface;

class RequestFormatter implements FormatterInterface
{
    public function resolveString($message, $addresses,$provider)
    {
        $messageDetails = array(
            "message"=>$message,
            "destinationAddresses"=>$addresses
            );
        $messageDetails = $this->mapToArray(
            ['sourceAddress',
            'deliveryStatusRequest',
            'binaryHeader',
            'version',
            'encoding',
            ],
            $messageDetails);

        $applicationDetails = array(
            'applicationId'=>$provider->app_id,
            'password'=>$provider->password,
            );

        return json_encode($applicationDetails+$messageDetails);
    }

    private function mapToArray(array $array,array $details)
    {
        foreach ($array as $element) {
            if (isset($this->{$element})) {
                $details = array_merge($details,array($element => $this->{$element}));
            }
        }

        return $details;
    }
}
