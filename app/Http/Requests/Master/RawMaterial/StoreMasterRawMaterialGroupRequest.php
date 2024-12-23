<?php

namespace App\Http\Requests\Master\RawMaterial;

use App\Models\Master\RawMaterial\MasterRawMaterialGroup;
use App\Models\Master\RawMaterial\MasterRawMaterialType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

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
        $validator = Validator::make($this->all(), [
            'codeRawMaterialType' => 'required',
        ]);

        $code = $this->input('codeRawMaterialType');
        // cek apakah type yang diinput ada didalam tabel
        $cekRawMaterialType = MasterRawMaterialType::where('codeRawMaterialType', $code)->firstOr(function () {
            return null;
        });
        if ($cekRawMaterialType === null) {
            $validator->errors()->add('codeRawMaterialType', 'Code raw material type not Found');
            throw new ValidationException($validator);
        }

        $data = MasterRawMaterialGroup::where('codeRawMaterialType', $code)
            ->orderBy('codeRawMaterialGroup', 'desc')->first();
        if ($data === null) {
            $code .= '001';
        } else {
            $latest_code = substr($data->codeRawMaterialGroup, -3);
            $code .= substr(strval((int)$latest_code + 1001), 1, 3);
        }

        $this->merge([
            'codeRawMaterialGroup' => $code,
            'nameRawMaterialGroup' => strtoupper($this->input('nameRawMaterialGroup')),
            'codeRawMaterialType' => strtoupper($this->input('codeRawMaterialType')),
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
            'codeRawMaterialGroup' => ['required', Rule::unique('master_raw_material_groups')->whereNull('deleted_at')],
            'nameRawMaterialGroup' => 'required|min:3|max:50',
            'unitOfMeasurement' => 'required|in:KG,PCS,LTR',
            'codeRawMaterialType' => 'required'
        ];
    }
}
