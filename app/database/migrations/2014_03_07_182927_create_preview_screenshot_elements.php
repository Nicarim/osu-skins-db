<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePreviewScreenshotElements extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('preview_screenshot_elements', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('preview_screenshot_id');
            $table->string('filename');
            $table->string('position');
            $table->integer('xoffset');
            $table->integer('yoffset');
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
	    Schema::drop('preview_screenshot_elements');
	}

}
