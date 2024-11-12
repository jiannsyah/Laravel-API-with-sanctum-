<?php

namespace App\Http\Requests\Master\Premix;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMasterPremixGroupRequest extends FormRequest
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
            'namePremixGroup' => 'required|min:5|max:50',
        ];
    }
}
