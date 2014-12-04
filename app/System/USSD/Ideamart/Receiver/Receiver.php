<?php

namespace BByer\System\USSD\Ideamart\Receiver;

class  Receiver
{

    protected $request = [];

    protected $validator;

    protected $formatter;

    public function __construct(RequestFormatter $formatter, RequestValidator $validator)
    {
        $this->validator = $validator;
        $this->formatter = $formatter;

    }

    public function receive(array $request)
    {
        $request = $this->validator->validate($request);
        $this->request = $this->formatter->format($request);

        return $request;
    }


}
