<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRequestRequest extends FormRequest
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
			'course_id' => [Rule::exists("courses", "id")],
			'day' => ['required', 'in:mon,tue,wed,thu,fri,sat,sun,daily,custom'],
			'hour' => ['required', 'numeric', 'between:0,24'],
		];
	}
}
