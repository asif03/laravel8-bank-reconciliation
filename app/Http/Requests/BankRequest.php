<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankRequest extends FormRequest
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
            'bank_name' => 'required|max:100',
            'ac_no' => 'required|max:13',
            'ac_title' => 'required|max:255',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'bank_name.required' => 'Bank must be required.',
            'bank_name.max' => 'Your bank name is too long.',
            'ac_no.required' => 'A/C no. must be required.',
            'ac_no.max' => 'A/C no. must be 13 digits.',
            'ac_title.required' => 'A/C No. is required',
        ];
    }
}
