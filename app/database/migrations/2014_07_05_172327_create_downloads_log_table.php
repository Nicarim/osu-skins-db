<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDownloadsLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('downloads_log', function(Blueprint $table) {
            $table->increments('id');
            $table->integer("skin_id")->default(0);
            $table->string("ip");
            $table->integer("count")->default(0);
            $table->timestamps();
        });
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	    Schema::drop('downloads_log');
	}

}
