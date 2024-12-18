<?php

namespace App\Http\Requests\Master\RawMaterial;

use App\Models\Master\MasterRawMaterial;
use App\Models\Master\MasterRawMaterialGroup;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class StoreMasterRawMaterialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    protected function prepareForValidation(): void
    {
        $validator = Validator::make($this->all(), [
            'codeRawMaterialGroup' => 'required',
        ]);

        $code = $this->input('codeRawMaterialGroup');
        // cek apakah group yang diinput ada didalam tabel
        $cekRawMaterialGroup = MasterRawMaterialGroup::where('codeRawMaterialGroup', $code)->firstOr(function () {
            return null;
        });
        if ($cekRawMaterialGroup === null) {
            $validator->errors()->add('codeRawMaterialGroup', 'Code raw material group not Found');
            throw new ValidationException($validator);
        }

        //otomatis penambahan kode 
        $data = MasterRawMaterial::where('codeRawMaterialGroup', $code)
            ->orderBy('codeRawMaterial', 'desc')->first();
        // 
        if ($data === null) {
            $code .= '001';
        } else {
            $latest_code = substr($data->codeRawMaterial, -3);
            $code .= substr(strval((int)$latest_code + 1001), 1, 3);
        }
        $codeRawMaterialType = substr($code, 0, 2);

        $this->merge([
            'codeRawMaterial' => $code,
            'nameRawMaterial' => strtoupper($this->input('nameRawMaterial')),
            'codeRawMaterialGroup' => strtoupper($this->input('codeRawMaterialGroup')),
            'codeRawMaterialType' => strtoupper($codeRawMaterialType)
        ]);
    }

    public function rules(): array
    {
        return [
            'codeRawMaterial' => 'required',
            'nameRawMaterial' => 'required|min:3|max:50',
            'brand' => 'min:3',
            'unitOfMeasurement' => 'required|in:KG,PCS,LTR',
            'status' => 'required|in:Active,Non-Active',
            'costPrice' => 'required|numeric|min:0',
            'codeRawMaterialGroup' => 'required',
            'codeRawMaterialType' => 'required'
        ];
    }
}
