<?php

namespace App\Http\Requests\Master\RawMaterial;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMasterRawMaterialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    // 
    protected function prepareForValidation(): void
    {
        $this->merge([
            'nameRawMaterial' => strtoupper($this->input('nameRawMaterial')),
            'brand' => strtoupper($this->input('brand')),
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
            'nameRawMaterial' => 'required|min:3|max:50',
            'brand' => 'min:3',
            'unitOfMeasurement' => 'required|in:KG,PCS,LTR',
            'status' => 'required|in:Active,Non-Active',
            'costPrice' => 'required|numeric|min:0',
        ];
    }
}
