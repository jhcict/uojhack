<?php

namespace BByer\System\Session;


use Illuminate\Contracts\Foundation\Application;
use BByer\System\Session\Contracts\SessionHandler;

class DatabaseSessionHandler implements SessionHandler
{

    protected $db;

    protected $application;

    protected $sessionId;

    protected $session;

    private $app_id;

    /**
     * @param \Illuminate\Contracts\Foundation\Application $application
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
        $this->session = $application->make('session');
    }


    public function verifySession()
    {
        $this->sessionId = $this->session->get('sessionId');
    }

    public function setParameters($request)
    {
        $this->sessionId = $request['sessionId'];
        if ($request['ussdOperation'] == "mo-init"
            && $this->db->table('ussd_session')
                ->where('sessionId', '=', $request['sessionId'])
                ->count()
        ) {

            $this->db
                ->table('ussd_session')
                ->where('sessionId', '=', $request['sessionId'])
                ->update([
                             'menu_path' => null,
                             'option'    => null,
                         ]);
        } elseif ($request['ussdOperation'] == "mo-init"
            && ! $this->db
                ->table('ussd_session')
                ->where('sessionId', '=', $request['sessionId'])
                ->count()
        ) {
            $this->db
                ->table('ussd_session')
                ->insert([
                             'sourceAddress' => $request['sourceAddress'],
                             'sessionId'     => $request['sessionId'],
                         ]);
        } elseif ($request['ussdOperation'] == 'mo-cont') {
        }
        $this->session->set('sessionId', $request['sessionId']);

    }

    /**
     * @return mixed
     */
    public function getSourceAddress()
    {
        $this->verifySession();

        return $this->db
            ->table('ussd_session')
            ->where('sessionId', '=', $this->sessionId)
            ->first()->sourceAddress;
    }

    /**
     * @return mixed
     */
    public function getSessionId()
    {
        $this->verifySession();

        return $this->sessionId;
    }

    public function setMenuPath($value = "")
    {
        $this->verifySession();
        $this->db
            ->table('ussd_session')
            ->where('sessionId', '=', $this->sessionId)
            ->update(['menu_path' => $value]);
    }

    public function getMenuPath()
    {
        $this->verifySession();
        $menu_path = $this->db
            ->table('ussd_session')
            ->where('sessionId', '=', $this->sessionId)
            ->first();
        if (isset($menu_path->menu_path)) {
            return $menu_path->menu_path;
        }

        return "ideamart.".$this->app_id.".ussd.menus.master_menu";

        // TODO: Implement getMenuPath() method.
    }

    public function setOption($message)
    {
        $this->verifySession();
        $message = (int) $message;
        $this->db
            ->table('ussd_session')
            ->where('sessionId', '=', $this->sessionId)
            ->update(['option' => $message]);
    }

    public function getOption()
    {
        $this->verifySession();
        $session = $this->db
            ->table('ussd_session')
            ->where('sessionId', '=', $this->sessionId)
            ->first();
        if (isset($session->option)) {
            return $session->option;
        } else {
            return null;
        }
        // TODO: Implement getOption() method.
    }

    public function getOperation()
    {
        $this->verifySession();
        $ussdop = $this->db
            ->table('ussd_session')
            ->where('sessionId', '=', $this->sessionId)
            ->first()->ussdOperation;

        return $ussdop;

        // TODO: Implement getOperation() method.
    }

    public function setOperation($value)
    {
        $this->verifySession();
        $this->db->table('ussd_session')
            ->where('sessionId', '=', $this->sessionId)
            ->update(['ussdOperation' => $value]);
    }

    public function isAction()
    {
        $this->verifySession();

        return $this->db->table('ussd_session')
            ->where('sessionId', '=', $this->sessionId)
            ->first()->action;
        // TODO: Implement isAction() method.
    }

    public function setAction($action)
    {
        $this->verifySession();

        if ( ! $this->db->table('ussd_session')
            ->where('sessionId', '=', $this->sessionId)
            ->first()->action
        )
            $this->db->table('ussd_session')
                ->where('sessionId', '=', $this->sessionId)
                ->update(['action' => $action]);
        // TODO: Implement setAction() method.
    }

    public function setAppId($id){
        $this->app_id  = $id;
    }

    public function getAppId(){
        return $this->app_id;
    }

}