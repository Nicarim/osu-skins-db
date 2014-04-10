<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSkinsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('skins', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id');
                $table->integer('gamemodes');
                $table->integer('hdsupport');
                $table->integer('nsfw');
                $table->integer('template')->default(0);
                $table->string("name");
                $table->text("description");
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
	    Schema::drop('skins');
	}

}
