<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LedgerRequest extends FormRequest
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
            'entry_type' => 'required',
            'name' => 'required|max:150',
            'particulars' => 'required|max:500',
            'cheque_no' => 'required|max:13',
            'issue_date' => 'required',
            'amount' => 'required',
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
            'entry_type.required' => 'Entry Type must be required.',
            'name.required' => 'Entry Type must be required.',
            'name.max' => 'Your Name is too long.',
            'particulars.required' => 'Particulars must be required.',
            'cheque_no.required' => 'Cheque no. must be required.',
            'cheque_no.max' => 'Cheque no. must be 15 digits.',
            'issue_date.required' => 'Issue Date must be required.',
            'amount.required' => 'Amount must be required.',
        ];
    }
}
