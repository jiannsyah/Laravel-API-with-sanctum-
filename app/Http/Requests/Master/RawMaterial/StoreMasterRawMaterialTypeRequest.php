<?php

namespace App\Http\Requests\Master\RawMaterial;

use App\Models\MasterRawMaterialType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreMasterRawMaterialTypeRequest extends FormRequest
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
        $latest_code = MasterRawMaterialType::query()->orderBy('codeRawMaterialType', 'desc')->first();
        $next_code = strval((int)$latest_code->codeRawMaterialType + 10);

        $this->merge([
            'codeRawMaterialType' => $next_code
        ]);
    }

    public function rules(): array
    {
        return [
            'codeRawMaterialType' => 'required',
            'nameRawMaterialType' => 'required',
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ((int)$this->input('codeRawMaterialType') === 100) {

                    $validator->errors()->add(
                        'code',
                        'The code has reached the limit'
                    );
                }
            }
        ];
    }
}
