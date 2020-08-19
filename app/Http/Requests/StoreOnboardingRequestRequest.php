<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOnboardingRequestRequest extends FormRequest
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
			"firstname" => ["required", "string", "max:16"],
			"lastname" => ["required", "string", "max:16"],
			"fullname_cn" => ["required", "string", "max:32"],
			"bornAt" => ["required", "date:Y-m-d", "before:today"],
			"city_code" => ["required", "regex:/^\d{5}$/"],
			"first_wechat_id" => ["nullable", "string", "max:32"],
			"first_phone" => ['required', "regex:/^\+?[0-9 ]{10,16}$/"],
			"second_phone" => ['required', "regex:/^\+?[0-9 ]{10,16}$/"],
		];
	}
}
