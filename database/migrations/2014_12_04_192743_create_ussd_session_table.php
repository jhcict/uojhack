<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUssdSessionTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ussd_session', function (Blueprint $table) {
            $table->increments('id');
            $table->mediumText('sessionId')->nullable();
            $table->mediumText('sourceAddress');
            $table->integer('action')->nullable();
            $table->string('ussdOperation')->nullable();
            $table->longText("menu_path")->nullable();
            $table->integer('option')->nullable();
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ussd_session');
    }

}