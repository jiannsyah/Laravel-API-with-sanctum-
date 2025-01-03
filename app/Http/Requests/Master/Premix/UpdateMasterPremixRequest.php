<?php

namespace App\Http\Requests\Master\Premix;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMasterPremixRequest extends FormRequest
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
            'namePremix' => strtoupper($this->input('namePremix')),
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
            'namePremix' => 'required|min:3',
            'unitOfMeasurement' => 'in:BKS,GR',
            'status' => 'in:Active,Non-Active',
        ];
    }
}
