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
            $table->integer("ishd");
            $table->integer("useroverriden")->default(0);
            $table->integer("issequence")->default(0);
            $table->integer("sequence_frame")->default(-1);
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
