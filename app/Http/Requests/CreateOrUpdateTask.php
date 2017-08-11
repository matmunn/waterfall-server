<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrUpdateTask extends FormRequest
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
            'description' => ['required', 'string'],
            'startTime' => ['required'],
            'endTime' => ['required'],
            'client' => ['required', 'integer'],
            'user' => ['required', 'integer'],
            'recurring' => ['required', 'boolean'],
            'recurrencePeriod' => ['required', 'integer'],
            'recurrenceType' => ['required', 'string'],
            'absence' => ['required', 'boolean'],
        ];
    }
}
