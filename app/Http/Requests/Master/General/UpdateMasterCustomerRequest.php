<?php

namespace App\Http\Requests\Master\General;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMasterCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    protected function prepareForValidation(): void
    {
        $this->merge([
            'nameCustomer' => strtoupper($this->input('nameCustomer')),
            'abbreviation' => strtoupper($this->input('abbreviation')),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nameCustomer' => 'required|max:50',
            'abbreviation' => 'required|max:20',
            'priceType' => 'required|in:WholesalePrice,NonWholesalePrice,Retail',
            'status' => 'required|in:Active,InActive',
            'ppn' => 'required|in:PPN,Non-PPN',
            'top' => 'required|numeric|min:0',
            'phone' => 'max:15|nullable',
            'email' => 'email|nullable',
            'npwp' => 'max:16|nullable',
            'nik' => 'max:16|nullable',
        ];
    }
}
