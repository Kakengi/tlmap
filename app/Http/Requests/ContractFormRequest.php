<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractFormRequest extends FormRequest
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
            'supplier_id' => 'required',
            'contract_title' => 'required',
            'contract_number' => 'required',
            'delivery_date' => 'required',
            'year_of_study' => 'required',
            // 'quantity' => 'required',
        ];
    }
}
