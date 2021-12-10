<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateVacationRequest extends FormRequest
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
            'title' => 'required|string',
            'request_message' => 'required|string',
            'type' => 'required|in:deserved,emergency',
            'mode' => 'required|in:daily,hourly',
            'from_date' => 'required|date',
            'to_date' => 'required_if:mode,daily|date|after_or_equal:from_date',
            'from_hour' => 'required_if:mode,hourly|string',
            'to_hour' => 'required_if:mode,hourly|string',
        ];
    }
}
