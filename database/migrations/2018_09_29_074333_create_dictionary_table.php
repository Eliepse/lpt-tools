<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDictionaryTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dictionary', function (Blueprint $table) {

			$table->increments('id');
			$table->string('character', 8);
			$table->string('definition')->nullable();
			$table->json('pinyin');
			$table->string('decomposition');
			$table->json('etymology')->nullable();
			$table->string('radical');
			$table->json('matches');

			$table->index('character');

		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('dictionary');
	}
}
