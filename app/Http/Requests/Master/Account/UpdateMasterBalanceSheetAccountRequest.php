<?php

namespace App\Http\Requests\Master\Account;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UpdateMasterBalanceSheetAccountRequest extends FormRequest
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
        // dd($this->route()->originalParameters());

        $this->merge([
            'nameAccountBalance' => strtoupper($this->input('nameAccountBalance')),
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
        $requests = $this->route()->originalParameters();
        $id = $requests['balance_sheet_account'];
        // dd($id);
        return [
            'nameAccountBalance' => ['required', 'max:50', Rule::unique('master_balance_sheet_accounts')->whereNull('deleted_at')->ignore($id)],
            'abbreviation' => ['required', 'max:25', Rule::unique('master_balance_sheet_accounts')->whereNull('deleted_at')->ignore($id)],
            'characteristicAccount' => 'required|in:Header,Total,Account',
            'typeAccount' => 'required|in:AK,PS,PD,BY,LL',
            'specialAccount' => 'required|in:KS,BK,RE,PCY,GENERAL',
        ];
    }
}
