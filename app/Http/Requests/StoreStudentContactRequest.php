<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentContactRequest extends FormRequest
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
			"first_wechat_id" => ["nullable", "string", "max:32"],
			"first_phone" => ['required', "regex:/^\+?[0-9 ]{10,16}$/"],
			"second_phone" => ['required', "regex:/^\+?[0-9 ]{10,16}$/"],
		];
	}
}
