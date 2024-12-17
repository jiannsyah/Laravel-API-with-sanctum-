<?php

namespace App\Http\Requests\Master\General;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMasterSalesmanRequest extends FormRequest
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
            'nameSalesman' => strtoupper($this->input('nameSalesman')),
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
            'nameSalesman' => 'required|max:50',
            'abbreviation' => 'required|max:20',
        ];
    }
}
