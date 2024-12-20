<?php

namespace App\Http\Requests\Master\General;

use App\Models\Master\MasterCustomer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StoreMasterCustomerRequest extends FormRequest
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
            'codeCustomer' => 'required|regex:/^[0-9][0-9]*$/|max:5|min:3',
        ]);

        $codeCustomer = $this->input('codeCustomer');

        //otomatis penambahan kode 
        $data = MasterCustomer::orderBy('codeCustomer', 'desc')->first();
        // 
        // dd($data);
        if ($data === null) {
            $nextCode = '001';
        } else {
            $latest_code = $data['codeCustomer'];
            // dd($latest_code);
            $nextCode = substr(strval((int)$latest_code + 1001), 1, 3);
        }

        $this->merge([
            'codeCustomer' => $nextCode,
            'nameCustomer' => strtoupper($this->input('nameCustomer')),
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
            'codeCustomer' => ['required', 'regex:/^[0-9][0-9]*$/', 'min:3', 'max:5', Rule::unique('master_customers')->whereNull('deleted_at')],
            'nameCustomer' => 'required|max:50',
            'abbreviation' => 'required|max:20',
            'priceType' => 'required|in:WholesalePrice,NonWholesalePrice,Retail',
            'status' => 'required|in:Active,InActive',
            'ppn' => 'required|in:PPN,Non-PPN',
            'top' => 'required|numeric|min:0',
            'phone' => 'max:15|nullable',
            'email' => 'email|nullable',
            'npwp' => 'max:16|nullable',
            'nik' => 'max:16|nullable',
        ];
    }
    public function messages()
    {
        return [
            'codeCustomer.regex' => 'Code customer must start with a number between 1 and 9.',
        ];
    }
}
