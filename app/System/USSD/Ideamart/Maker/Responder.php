<?php

namespace BByer\System\USSD\Ideamart\Maker;


use Illuminate\Contracts\Foundation\Application;
use BByer\System\Session\Contracts\SessionHandler;

/**
 * Class Responder
 * @package BByer\System\USSD\Ideamart\Maker
 */
class Responder
{

    /**
     */
    protected $session;

    /**
     * @var \Illuminate\Contracts\Config\Config
     */
    protected $config;


    protected $menu_path;

    protected $option;

    protected $application;

    protected $actionPath;

    protected $variables;

    protected $actionTrigger;

    protected $actionMessage;

    protected $message;

    /**
     * @param \BByer\System\Session\Contracts\SessionHandler|\BByer\System\USSD\Ideamart\Session\Contracts\SessionHandler $sessionHandler
     * @param \Illuminate\Contracts\Foundation\Application                                                                        $application
     *
     * @internal param \Illuminate\Contracts\Config\Config $config
     */
    public function __construct(SessionHandler $sessionHandler, Application $application)
    {
        $this->session = $sessionHandler;
        $this->application = $application;
        $this->config = $this->application->make('config');
    }

    public function produceResponse(Parser $parser, MessageTranslator $translator)
    {

        $session = $translator->getSession();
        $this->menu_path = $session->getMenuPath();
        $this->option = $session->getOption();

        if ($this->option) {
            $menu = $parser->getMenuPlain($session);

            if ($menu['type'] == "message") {
                $this->message = $menu['message'];
            } else {
                $this->message = $this->findActionPath($parser, $session)->triggerAction()->getResponse();
            }
        } elseif ($this->option == null) {
            $this->message = $parser->makeMenu($session);
        }

        return $this->message;
    }

    private function findActionPath(Parser $parser, SessionHandler $session)
    {
        $isAction = $this->session->isAction();
        if ($isAction) {
            $action = ($parser->getMenuPlain($session)['options'][$isAction]['action']);
            \Log::info($parser->getMenuPlain($session));
            $this->variables = ($parser->getMenuPlain($session)['options'][$isAction]['variables']);
        } else {
            $action = ($parser->getMenuPlain($session)['options'][$this->option]['action']);
            $this->variables = ($parser->getMenuPlain($session)['options'][$this->option]['variables']);
        }
        $this->actionPath = explode('@', $action)[0];
        $this->actionTrigger = explode('@', $action)[1];

        return $this;
    }

    private function triggerAction()
    {
        $actionPath = $this->actionPath;
        $action = $this->application->make($actionPath);
        $this->resolveVariables();
        $this->actionMessage = call_user_func_array([$action, $this->actionTrigger], $this->variables);
        $this->session->setAction($this->option);

        return $this;
    }

    private function getResponse()
    {
        return $this->actionMessage;
    }


    public function getMessage()
    {
        return $this->message;
    }

    private function resolveVariables()
    {
        $variablesd = [];
        foreach ( $this->variables as $variable => $value ) {
            if (method_exists($this->session, $value)) {

                $variablesd[$variable] = $this->session->{$value}();
            } else {

                $variablesd[$variable] = $value;
            }

        }

        $this->variables = $variablesd;


    }


}