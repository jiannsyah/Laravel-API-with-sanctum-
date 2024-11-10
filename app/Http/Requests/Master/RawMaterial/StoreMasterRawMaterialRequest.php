<?php

namespace App\Http\Requests\Master\RawMaterial;

use App\Models\MasterRawMaterial;
use App\Models\MasterRawMaterialGroup;
use Illuminate\Foundation\Http\FormRequest;

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
        $code = $this->input('codeRawMaterialGroup');
        $IdRawMaterialGroup = MasterRawMaterialGroup::where('codeRawMaterialGroup', $code)->first()->id;
        $IdRawMaterialType = MasterRawMaterialGroup::where('codeRawMaterialGroup', $code)->first()->codeRawMaterialType;
        // 
        $data = MasterRawMaterial::where('codeRawMaterialGroup', $IdRawMaterialGroup)
            ->orderBy('codeRawMaterial', 'desc')->first();
        // 
        if ($data === null) {
            $code .= '001';
        } else {
            $latest_code = substr($data->codeRawMaterial, -3);
            $code .= substr(strval((int)$latest_code + 1001), 1, 3);
        }
        // dd($code);

        $this->merge([
            'codeRawMaterial' => $code,
            'nameRawMaterial' => strtoupper($this->input('nameRawMaterial')),
            'codeRawMaterialGroup' => $IdRawMaterialGroup,
            'codeRawMaterialType' => $IdRawMaterialType
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
            // 
            'codeRawMaterialGroup' => 'required',
            'codeRawMaterialType' => 'required'
            // 'unitOfMeasurement' => ['required', new Enum(UOMType::class)],
        ];
    }
}
