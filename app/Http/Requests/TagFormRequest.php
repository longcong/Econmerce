<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TagFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            $rules = [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],
            ],
        ];
        if($this->getMethod() == 'POST')[
            $rules += [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:tags,name',
                ],
            ],
        ];
        if($this->getMethod() == 'PUT')[
            $rules += [
                'name' => [
                    'required',
                    'string',
                    'max:255'
                ],
            ],
        ];
        return $rules;
    }
}