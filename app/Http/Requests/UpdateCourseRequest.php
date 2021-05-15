<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCourseRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}


	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			"name" => ["required", "string", "between:2,20"],
			"description" => ["string", "nullable", "between:0,250"],
//			We do not allow moving a course to another school
//			"school" => ["required", "string", "between:2,250"],
			"category" => ["required", "string", "between:2,250"],
			"duration" => ["required", "integer", "between:1,18000"],
			"price" => ["required", "integer", "between:0,18000"],
			"duration_denominator" => ["required", "string", Rule::in(["year", "month", "week", "day"])],
			"price_denominator" => ["required", "string", Rule::in(["year", "month", "week", "day"])],
			"schedules" => ["required", "array"],
		];
	}
}
