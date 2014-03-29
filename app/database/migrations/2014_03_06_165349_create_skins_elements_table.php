<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSkinsElementsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('skins_elements', function(Blueprint $table) {
            $table->increments('id');
            $table->integer("element_id");
            $table->integer("skin_id");
            $table->string("filename");
            $table->string("extension");
            $table->integer("highdef");
            $table->integer("hashd");
            $table->integer("size");
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
	    Schema::drop('skins_elements');
	}

}
