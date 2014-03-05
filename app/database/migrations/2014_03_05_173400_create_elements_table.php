<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateElementsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('elements', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('group_id');
                $table->string('filename');
                $table->string('extension');
                $table->text('description');
                $table->integer('width');
                $table->integer('height');
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
	    Schema::drop('elements');
	}

}
