<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class StoreStudentRequest
 *
 * @package App\Http\Requests
 */
class StoreStudentRequest extends FormRequest
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
			"fullname" => ["required", "string", "max:32"],
			"wechatId" => ["nullable", "string", "max:32"],
//			"course_id" => ["required", Rule::exists("courses")],
//			"schedule" => ["required", "regex:/^(mon|tue|wed|thu|fri|sat|sun):[0-9]{1,2}$/"]
			"emergency" => ['required', "regex:/^\+?[0-9 ]{10,16}$/"]
		];
	}
}
