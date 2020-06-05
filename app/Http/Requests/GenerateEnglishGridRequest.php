<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class GenerateEnglishGridRequest
 *
 * @package App\Http\Requests
 */
class GenerateEnglishGridRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'title' => 'required|string|max:50',
			'words' => 'required|string|min:3|max:1500',
			'pinyin' => 'required|boolean'
		];
	}
}
