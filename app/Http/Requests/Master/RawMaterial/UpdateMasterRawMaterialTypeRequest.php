<?php

namespace App\Http\Requests\Master\RawMaterial;

use App\Models\MasterRawMaterialType;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMasterRawMaterialTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    // protected function prepareForValidation(): void
    // {
    //     $id = $this->route('raw_material_type'); // Ambil ID dari parameter route
    //     $data = MasterRawMaterialType::findOrFail($id);
    //     // dd($data);

    //     $this->merge([
    //         'codeRawMaterialType' => $data->codeRawMaterialType
    //     ]);
    // }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nameRawMaterialType' => 'required'
        ];
    }
}
