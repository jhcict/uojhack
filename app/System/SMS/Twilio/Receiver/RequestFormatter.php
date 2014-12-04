<?php

namespace BByer\System\SMS\Ideamart\Receiver;
use Illuminate\Contracts\Foundation\Application;
use BByer\System\SMS\Contracts\Receiver\FormatterInterface;
use BByer\System\ConfigLoader\Contracts\ConfigLoader;
use BByer\System\Session\Contracts\SessionHandler;

class RequestFormatter implements FormatterInterface
{


    protected $config;

    protected $configLoader;

    protected $sessionHandler;

    public function __construct(Application $application,SessionHandler $sessionHandler,ConfigLoader $configLoader){
        $this->config = $application['config'];
        $this->sessionHandler = $sessionHandler;
        $this->configLoader = $configLoader;
    }
    public function format($request)
    {
        $this->sessionHandler->setAppId($request['applicationId']);
        $this->configLoader->setApplication();

//        $request['message'] = substr($request['message'],6);

        return $request;
    }
}
