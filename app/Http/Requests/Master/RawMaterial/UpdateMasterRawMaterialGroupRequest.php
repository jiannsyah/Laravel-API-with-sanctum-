<?php

namespace App\Http\Requests\Master\RawMaterial;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMasterRawMaterialGroupRequest extends FormRequest
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
            'nameRawMaterialGroup' => strtoupper($this->input('nameRawMaterialGroup')),
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
            'nameRawMaterialGroup' => 'required|min:3|max:50',
            'unitOfMeasurement' => 'required|in:KG,PCS,LTR',
        ];
    }
}
