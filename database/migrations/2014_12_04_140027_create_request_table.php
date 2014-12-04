<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::create('requests', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('requester');
            $table->string('requested_provider', 60);
            $table->string('provider_response',60);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('requests');
		//
	}

}
