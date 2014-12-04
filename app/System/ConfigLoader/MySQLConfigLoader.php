<?php

namespace BByer\System\ConfigLoader;


use BByer\System\ConfigLoader\Contracts\ConfigLoader;
use BByer\System\Session\Contracts\SessionHandler;
use Illuminate\Database\DatabaseManager;

class MySQLConfigLoader implements ConfigLoader
{



    protected $config;

    protected $db;

    protected $session;

    public function __construct(SessionHandler $sessionHandler, DatabaseManager $db)
    {
        $this->session = $sessionHandler;
        $this->db = $db;
        $this->config = app('config');
    }


    public function setApplication($applicationId = null)
    {
        $app_id = isset($applicationId) ? $applicationId : $this->session->getAppId();
        $db = $this->db->table('applications')->where('app_id', $app_id)->first();
        \Log::info(unserialize($db->app_data));
        $this->config->set('system.' . $app_id, unserialize($db->app_data));
    }

    public function addApplication()
    {

        $this->db->table('applications')->insert(['app_data'=>$this->config->get('ideamart')]);


    }

    public function get($name)
    {
    }

    public function set($name, $value)
    {
    }

}