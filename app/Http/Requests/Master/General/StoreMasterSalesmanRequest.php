<?php

namespace App\Http\Requests\Master\General;

use App\Models\Master\MasterSalesman;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMasterSalesmanRequest extends FormRequest
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
        //otomatis penambahan kode 
        $data = MasterSalesman::orderBy('codeSalesman', 'desc')->first();
        // 
        // dd($data);
        if ($data === null) {
            $nextCode = '01';
        } else {
            $latest_code = $data['codeSalesman'];
            $nextCode = substr(strval((int)$latest_code + 101), 1, 2);
        }

        $this->merge([
            'codeSalesman' => $nextCode,
            'nameSalesman' => strtoupper($this->input('nameSalesman')),
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
            'codeSalesman' => ['required', 'regex:/^[0-9][0-9]*$/', 'max:2', Rule::unique('master_salesmen')->whereNull('deleted_at')],
            'nameSalesman' => 'required|max:50',
            'abbreviation' => 'required|max:20',
        ];
    }

    public function messages()
    {
        return [
            'codeSalesman.regex' => 'Code customer must start with a number between 1 and 9.',
        ];
    }
}
