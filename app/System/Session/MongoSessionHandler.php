<?php

namespace BByer\System\Session;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\DatabaseManager;
use BByer\System\Session\Contracts\SessionHandler;

class MongoSessionHandler implements SessionHandler
{

    protected $db;

    protected $application;

    protected $sessionId;

    protected $session;

    private   $app_id;

    /**
     * @param \Illuminate\Contracts\Foundation\Application $application
     * @param \Illuminate\Database\DatabaseManager         $databaseManager
     */
    public function __construct(Application $application, DatabaseManager $databaseManager)
    {
        $this->application = $application;
        $this->db = $databaseManager->connection('mongodb');
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
            && $this->db->collection('ussd_session')
                ->where('sessionId', $request['sessionId'])
                ->count()
        ) {

            $this->db
                ->collection('ussd_session')
                ->where('sessionId', $request['sessionId'])
                ->update([
                             'menu_path'     => null,
                             'option'        => null,
                             'ussdOperation' => null
                         ]);
        } elseif ($request['ussdOperation'] == "mo-init"
            && ! $this->db
                ->collection('ussd_session')
                ->where('sessionId', $request['sessionId'])
                ->count()
        ) {
            $this->db
                ->collection('ussd_session')
                ->insert([
                             'sourceAddress' => $request['sourceAddress'],
                             'sessionId'     => $request['sessionId'],
                         ]);
        } elseif ($request['ussdOperation'] == 'mo-cont') {
        }
        $this->session->set('sessionId', $request['sessionId']);

        // TODO: Implement setParameters() method.
    }

    public function getSourceAddress()
    {
        $this->verifySession();

        return $this->db
                   ->collection('ussd_session')
                   ->where('sessionId', $this->sessionId)
                   ->first()['sourceAddress'];
    }

    public function getSessionId()
    {
        $this->verifySession();

        return $this->sessionId;
    }

    public function setMenuPath($value = "")
    {
        $this->verifySession();
        $this->db
            ->collection('ussd_session')
            ->where('sessionId', $this->sessionId)
            ->update(['menu_path' => $value]);
        // TODO: Implement setMenuPath() method.
    }

    public function getMenuPath()
    {
        $this->verifySession();
        $menu_path = $this->db
            ->collection('ussd_session')
            ->where('sessionId', $this->sessionId)
            ->first();
        if (isset($menu_path['menu_path'])) {
            return $menu_path['menu_path'];
        }

        return "system." . $this->app_id . ".ussd.menus.master_menu";

    }

    public function setOption($message)
    {
        $this->verifySession();
        $message = (int) $message;
        $this->db
            ->collection('ussd_session')
            ->where('sessionId', $this->sessionId)
            ->update(['option' => $message]);
        // TODO: Implement setOption() method.
    }

    public function getOption()
    {
        $this->verifySession();
        $session = $this->db
            ->collection('ussd_session')
            ->where('sessionId', $this->sessionId)
            ->first();
        if (isset($session['option'])) {
            return $session['option'];
        } else {
            return null;
        }
        // TODO: Implement getOption() method.
    }

    public function getOperation()
    {
        $this->verifySession();
        $ussd_op = $this->db
                       ->collection('ussd_session')
                       ->where('sessionId', $this->sessionId)
                       ->first()['ussdOperation'];

        return $ussd_op;
        // TODO: Implement getOperation() method.
    }

    public function setOperation($value)
    {
        $this->verifySession();
        $this->db->collection('ussd_session')
            ->where('sessionId', $this->sessionId)
            ->update(['ussdOperation' => $value]);
        // TODO: Implement setOperation() method.
    }

    public function isAction()
    {
        $this->verifySession();

        if (isset($this->db->collection('ussd_session')
                      ->where('sessionId', $this->sessionId)
                      ->first()['action'])) {
            return $this->db->collection('ussd_session')
                       ->where('sessionId', $this->sessionId)
                       ->first()['action'];
        }
        // TODO: Implement isAction() method.
    }

    public function setAction($action)
    {
        $this->verifySession();

        if (isset($this->db->collection('ussd_session')
                      ->where('sessionId', $this->sessionId)
                      ->first()['action'])
        )
            $this->db->collection('ussd_session')
                ->where('sessionId', $this->sessionId)
                ->update(['action' => $action]);
        // TODO: Implement setAction() method.
    }

    public function setAppId($id)
    {
        $this->app_id = $id;
    }

    public function getAppId()
    {
        return $this->app_id;
    }
}