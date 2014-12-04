<?php namespace BByer\System\Session\Contracts;


interface SessionHandler
{

    public function getSourceAddress();

    public function setParameters($request);

    public function setMenuPath($value = "");

    public function getMenuPath();

    public function setOption($message);

    public function getOption();

    public function getOperation();

    public function setOperation($value);

    public function verifySession();

    public function getSessionId();

    public function isAction();

    public function setAction($action);

    public function setAppId($APP_ID);

    public function getAppId();

}