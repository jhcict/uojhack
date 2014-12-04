<?php
namespace BByer\System\SMS\Ideamart\Receiver;
use BByer\System\SMS\Ideamart\Receiver\Contracts\HandlerInterface;

class Handler implements HandlerInterface
{
    private $request;

    public function handle(FormatterInterface $request)
    {
        $this->request = $request;
    # code...
    }
}
