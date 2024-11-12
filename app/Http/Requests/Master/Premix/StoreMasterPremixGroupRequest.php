<?php

namespace App\Http\Requests\Master\Premix;

use App\Models\MasterPremixGroup;
use App\Models\MasterRawMaterialType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class StoreMasterPremixGroupRequest extends FormRequest
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
            'codePremixGroup' => 'required|regex:/^[1-9][0-9]*$/|max:5'
        ]);
        //cek 2 digit awl tidak boleh sama dengan master raw material type
        $existType = MasterRawMaterialType::where('codeRawMaterialType', substr($this->codePremixGroup, 0, 2))->exists();
        if ($existType) {
            $validator->errors()->add('codePremixGroup', 'The first 2 digits cannot be the same as the raw material type');
            throw new ValidationException($validator);
        }
        // 
        $exists = MasterPremixGroup::where('codePremixGroup', $this->codePremixGroup)->exists();
        if ($exists) {
            $validator->errors()->add('codePremixGroup', 'Premix Group already exists');

            throw new ValidationException($validator);
        }
        $this->merge([
            'codePremixGroup' => strtoupper($this->input('codePremixGroup')),
            'namePremixGroup' => strtoupper($this->input('namePremixGroup')),
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
            'codePremixGroup' => 'required|regex:/^[1-9][0-9]*$/|max:5',
            'namePremixGroup' => 'required|min:5|max:50',
        ];
    }
    public function messages()
    {
        return [
            'codePremixGroup.regex' => 'Product code must start with a number between 1 and 9.',
        ];
    }
}
