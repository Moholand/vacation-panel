<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AdminUpdateDepartmentRequest extends FormRequest
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
            'name' => ['required', 'string', 
                        Rule::unique('departments')->ignore(request()->name, 'name')],
            'head_id' => ['required', 'numeric', 
                        Rule::unique('departments')->ignore(request()->head, 'head_id')],
        ];
    }
}
