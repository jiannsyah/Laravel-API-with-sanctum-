<?php

namespace App\Http\Requests\Master\Product;

use App\Models\MasterProductGroup;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class StoreMasterProductGroupRequest extends FormRequest
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
            'codeProductGroup' => 'required|max:3'
        ]);

        $exists = MasterProductGroup::where('codeProductGroup', $this->codeProductGroup)->exists();

        if ($exists) {
            $validator->errors()->add('codeProductGroup', 'Product Group already exists');

            throw new ValidationException($validator);
        }

        $this->merge([
            'codeProductGroup' => strtoupper($this->input('codeProductGroup')),
            'nameProductGroup' => strtoupper($this->input('nameProductGroup')),
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
            'codeProductGroup' => 'required|max:3',
            'nameProductGroup' => 'required|min:3|max:50',
        ];
    }
}
