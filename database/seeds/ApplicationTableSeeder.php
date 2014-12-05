<?php

use BByer\Application;
use Illuminate\Database\Seeder;

class ApplicationTableSeeder  extends Seeder{


    public function run(){
        DB::table('applications')->truncate();
        $app = new Application();

        $app->app_id = "APP_009076";
        $app->app_data = serialize(app('config')->get('system'));

        $app->save();
    }
}