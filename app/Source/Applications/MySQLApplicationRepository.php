<?php

namespace BByer\Source\Applications;


use BByer\Source\Core\EloquentRepository;
use Illuminate\Database\DatabaseManager;

class MySQLApplicationRepository extends EloquentRepository implements ApplicationRepository
{

    protected $db;

    public function __construct(Application $model, DatabaseManager $db)
    {
        $this->db = $db;
        $this->model = $model;
    }

    public function searchApplication($provider, $app_id)
    {
        $app = $this->db->table('applications')->where('app_id', '=', $app_id)->first();

        return $app;
    }


    public function getAllNames()
    {
        return $this->model->all(['name']);
    }
}