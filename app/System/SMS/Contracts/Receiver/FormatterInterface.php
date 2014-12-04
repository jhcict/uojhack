<?php

namespace BByer\System\SMS\Contracts\Receiver;

use Illuminate\Contracts\Foundation\Application;
use BByer\System\ConfigLoader\Contracts\ConfigLoader;
use BByer\System\Session\Contracts\SessionHandler;

interface FormatterInterface
{

    public function __construct(Application $application, SessionHandler $sessionHandler, ConfigLoader $configLoader);

    public function format($validatedRequest);
}
