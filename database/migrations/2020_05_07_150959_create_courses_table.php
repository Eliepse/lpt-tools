<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('courses', function (Blueprint $table) {
			$table->id();
			$table->string("name", 32);
			$table->string("school", 16);
			$table->string("category", 16);
			$table->unsignedSmallInteger("price")->default(0);
			$table->string("description");
			$table->unsignedSmallInteger("duration")->default(60);
			$table->json("schedules");
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('courses');
	}
}
