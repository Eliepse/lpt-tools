<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCourseRequest extends FormRequest
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
			"name" => ["required", "string", "between:2,32"],
			"school" => ["required"],
			"category" => ["required", "string", "between:2,16"],
			"duration" => ["required", "integer", "between:1,18000"],
			"duration_denominator" => ["required", "string", Rule::in(["year", "month", "week", "day"])],
			"price" => ["required", "integer", "between:0,18000"],
			"price_denominator" => ["required", "string", Rule::in(["year", "month", "week", "day"])],
		];
	}
}
