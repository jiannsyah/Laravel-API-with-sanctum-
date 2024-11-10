<?php

namespace App\Http\Requests\Master\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMasterProductGroupRequest extends FormRequest
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
            'nameProductGroup' => 'required|min:3|max:50'
        ];
    }
}
