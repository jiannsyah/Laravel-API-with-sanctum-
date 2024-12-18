<?php

namespace App\Http\Requests\Master\General;

use App\Models\Master\MasterSupplier;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StoreMasterSupplierRequest extends FormRequest
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
        // $validator = Validator::make($this->all(), [
        //     'codeSupplier' => 'required|regex:/^[0-9][0-9]*$/|max:5|min:3',
        // ]);

        // $codeSupplier = $this->input('codeSupplier');

        //otomatis penambahan kode 
        $data = MasterSupplier::orderBy('codeSupplier', 'desc')->first();
        // 
        // dd($data);
        if ($data === null) {
            $nextCode = '001';
        } else {
            $latest_code = $data['codeSupplier'];
            // dd($latest_code);
            $nextCode = substr(strval((int)$latest_code + 1001), 1, 3);
        }

        $this->merge([
            'codeSupplier' => $nextCode,
            'nameSupplier' => strtoupper($this->input('nameSupplier')),
            'abbreviation' => strtoupper($this->input('abbreviation')),
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
            'codeSupplier' => ['required', 'regex:/^[0-9][0-9]*$/', 'min:3', 'max:5', Rule::unique('master_suppliers')->whereNull('deleted_at')],
            'nameSupplier' => 'required|max:50',
            'abbreviation' => 'required|max:20',
            'ppn' => 'required|in:PPN,Non-PPN',
            'top' => 'required|numeric|min:0',
            'phone' => 'max:15|nullable',
            'email' => 'email|nullable',
        ];
    }

    public function messages()
    {
        return [
            'codeSupplier.regex' => 'Code customer must start with a number between 1 and 9.',
        ];
    }
}
