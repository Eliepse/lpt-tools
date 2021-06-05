<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReviewToCoursesRegistrations extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('course_registrations', function (Blueprint $table) {
			$table->dateTime("reviewed_at")->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('course_registrations', function (Blueprint $table) {
			$table->dropColumn("reviewed_at");
		});
	}
}
