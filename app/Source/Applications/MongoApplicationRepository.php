<?php

namespace BByer\Source\Applications;


use Illuminate\Database\DatabaseManager;
use BByer\Source\Core\MongoRepository;

class MongoApplicationRepository extends MongoRepository implements ApplicationRepository
{

    protected $db;

    public function __construct(Application $model, DatabaseManager $db)
    {
        $this->db = $db->connection('mongodb');
        $this->model = $model;
    }

    public function searchApplication($provider, $app_id)
    {
        $app = $this->db->collection('applications')->where(
            ['sms.providers.' . $provider . '.registered_applications' => ['$in' => [$app_id]]])->first();

        return $app;
    }


    public function getAllNames()
    {
        return $this->model->all(['name']);
    }
}