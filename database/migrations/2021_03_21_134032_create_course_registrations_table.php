<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseRegistrationsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('course_registrations', function (Blueprint $table) {
			$table->id();
			$table->string("uid")->index();
			$table->string("school");
			$table->string("category");
			$table->json("course");
			$table->json("schedule");
			$table->json("student");
			$table->json("contact");
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
		Schema::dropIfExists('course_registrations');
	}
}
