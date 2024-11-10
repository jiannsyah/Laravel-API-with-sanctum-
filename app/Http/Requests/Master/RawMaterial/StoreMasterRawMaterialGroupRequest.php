<?php

namespace App\Http\Requests\Master\RawMaterial;

use App\Models\MasterRawMaterialGroup;
use App\Models\MasterRawMaterialType;
use App\UOMType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreMasterRawMaterialGroupRequest extends FormRequest
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
        // menmbahkan code group otomatis berdasarkan type yang diinput
        // 
        $code = $this->input('codeRawMaterialType');
        // 
        // mencari id type berdasarkan code unique
        $IdRawMaterialType = MasterRawMaterialType::where('codeRawMaterialType', $code)->first()->id;
        // 
        $data = MasterRawMaterialGroup::where('codeRawMaterialType', $IdRawMaterialType)
            ->orderBy('codeRawMaterialGroup', 'desc')->first();
        // 
        if ($data === null) {
            $code .= '001';
        } else {
            $latest_code = substr($data->codeRawMaterialGroup, -3);
            $code .= substr(strval((int)$latest_code + 1001), 1, 3);
        }

        $this->merge([
            'codeRawMaterialGroup' => $code,
            'nameRawMaterialGroup' => strtoupper($this->input('nameRawMaterialGroup')),
            'codeRawMaterialType' => $IdRawMaterialType,
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
            'codeRawMaterialGroup' => 'required',
            'nameRawMaterialGroup' => 'required|min:3|max:50',
            'unitOfMeasurement' => 'required|in:KG,PCS,LTR',
            'codeRawMaterialType' => 'required'
            // 'unitOfMeasurement' => ['required', new Enum(UOMType::class)],
        ];
    }
}
