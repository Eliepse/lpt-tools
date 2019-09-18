<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkingGridRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'className' => 'required|string|max:50',
            'characters' => 'required|string|min:1',
            'columns' => 'required|integer|min:6',
            'lines' => 'required|integer|min:1',
            'models' => 'required|int|min:0|max:20',
            'emptyLines' => 'required|int|min:0|max:50',
            'date' => 'sometimes|nullable|date:Y-m-d',
            'month' => 'sometimes|integer|between:1,12',
            'stokes' => 'sometimes|accepted',
            'pinyin' => 'sometimes|accepted',
        ];
    }
}
