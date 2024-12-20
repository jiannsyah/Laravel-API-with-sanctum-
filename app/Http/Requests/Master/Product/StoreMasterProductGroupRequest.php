<?php

namespace App\Http\Requests\Master\Product;

use App\Models\Master\MasterProductGroup;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
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
            'codeProductGroup' => ['required', 'max:3', Rule::unique('master_product_groups')->whereNull('deleted_at')],
            'nameProductGroup' => 'required|min:3|max:50',
        ];
    }
}
