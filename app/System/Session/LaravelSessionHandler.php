<?php

namespace BByer\System\USSD\Ideamart\Session;


use Illuminate\Contracts\Foundation\Application;
use BByer\System\Session\Contracts\SessionHandler;

/**
 * Class LaravelSessionHandler
 * @package BByer\System\USSD\Ideamart\Session
 */
class LaravelSessionHandler implements SessionHandler
{

    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * @var mixed
     */
    protected $session;

    /**
     * @var mixed
     */
    protected $config;

    /**
     * @param \Illuminate\Contracts\Foundation\Application $application
     */
    public function __construct(Application $application)
    {

        $this->app = $application;
        $this->session = $this->app['session'];
        $this->config = $this->app['config'];

    }

    /**
     * @param $requests
     */
    public function setParameters($requests)
    {
        foreach ( $requests as $key => $request ) {
            \Log::info($key);
            \Log::info($request);
            $this->session->set($key, $request);
        }
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return mixed
     */
    public function __set($name = '', $value = '')
    {
        if ( ! is_null($name) && ! is_null($value)) {
            return $this->session->set($name, $value);
        }

    }

    /**
     * @return mixed
     */
    public function getSourceAddress()
    {
        // TODO: Implement getSourceAddress() method.
    }


    /**
     * @return mixed
     */
    public function getSessionId()
    {
        $this->session->get('sessionId');
        // TODO: Implement getSessionId() method.
    }

    /**
     * @return mixed
     */
    public function getPG()
    {
        // TODO: Implement getPG() method.
    }

    /**
     * @return mixed
     */
    public function setSourceAddress()
    {
        // TODO: Implement setSourceAddress() method.
    }

    /**
     * @return mixed
     */
    public function setSessionId()
    {
        // TODO: Implement setSessionId() method.
    }

    /**
     * @return mixed
     */
    public function setPG()
    {
        // TODO: Implement setPG() method.
    }

    public function setMenuPath($value = "")
    {
        $this->session->set('menu_path', $value);
        // TODO: Implement setMenuPath() method.
    }

    public function getMenuPath()
    {
        return $this->session->get('menu_path',"ideamart.ussd.menus.master_menu");
        // TODO: Implement getMenuPath() method.
    }

    public function setOption($message)
    {
        // TODO: Implement setOption() method.
    }

    public function getOption()
    {
        // TODO: Implement getOption() method.
    }

    public function getOperation()
    {
        // TODO: Implement getOperation() method.
    }

    public function setOperation($value)
    {
        // TODO: Implement setOperation() method.
    }

    public function verifySession()
    {
        // TODO: Implement verifySession() method.
    }

    public function isAction()
    {
        // TODO: Implement isAction() method.
    }

    public function setAction($action)
    {
        // TODO: Implement setAction() method.
    }

    public function setAppId($APP_ID)
    {
        // TODO: Implement setAppId() method.
    }

    public function getAppId()
    {
        // TODO: Implement getAppId() method.
    }
}