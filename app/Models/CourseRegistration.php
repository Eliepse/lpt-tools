<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class CourseRegistration
 *
 * @package App\Models
 * @property-read  int $id
 * @property string $uid
 * @property string $school
 * @property string $category
 * @property array $course
 * @property array $schedule
 * @property array $student
 * @property array $contact
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $reviewed_at
 */
final class CourseRegistration extends Model
{
	protected $table = "course_registrations";
	protected $fillable = [
		"school",
		"category",
		"course",
		"schedule",
		"student",
		"contact",
	];
	protected $casts = [
		"course" => "array",
		"schedule" => "array",
		"student" => "array",
		"contact" => "array",
	];


	protected static function booted()
	{
		CourseRegistration::saving(function (CourseRegistration $registration) {
			if (! $registration->uid) {
				$registration->uid = Str::random(12);
			}
		});
	}


	public function review()
	{
		$this->reviewed_at = Carbon::now();
	}


	public function unreview()
	{
		$this->reviewed_at = null;
	}
}