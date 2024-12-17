<?php

namespace App\Http\Requests\Master\General;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMasterSupplierRequest extends FormRequest
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
            'nameSupplier' => strtoupper($this->input('nameSupplier')),
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
            'nameSupplier' => 'required|max:50',
            'abbreviation' => 'required|max:20',
            'ppn' => 'required|in:PPN,Non-PPN',
            'top' => 'required|numeric|min:0',
            'phone' => 'max:15|nullable',
            'email' => 'email|nullable',
        ];
    }
}
