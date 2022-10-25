<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            'first_name' => 'required|string',
            'middle_name' => 'required|string',
            'last_name' => 'string|required',
            'email' => 'required|email',
            'mobile_number' => 'required',
            'account_name' => 'required|string',
            'attributes' => 'required',
            'acquisition_details' => 'required',
            'dob' => 'required',
            'gender' => 'required',
            'identity_id' => 'required',
            'subscription' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'First_name is required!',
            'middle_name.required' => 'Middle_name is required!',
            'last_name.required' => 'Last_name is required!'
        ];
    }
}
