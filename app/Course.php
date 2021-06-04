<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class Course
 *
 * @package App
 * @property-read int $id
 * @property string $name
 * @property string $school
 * @property string $category
 * @property int $price
 * @property string $description
 * @property int $duration
 * @property string $price_denominator
 * @property Collection $schedules
 * @property string $duration_denominator
 */
final class Course extends Model
{
	/* Model configuration */
	protected $table = 'courses';
	protected $guarded = [];
	public $timestamps = false;
	protected $casts = [
		"price" => "integer",
		"duration" => "integer",
		"schedules" => "collection",
	];
}
