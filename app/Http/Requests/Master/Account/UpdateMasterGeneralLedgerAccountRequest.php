<?php

namespace App\Http\Requests\Master\Account;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMasterGeneralLedgerAccountRequest extends FormRequest
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
            'nameGeneralLedgerAccount' => strtoupper($this->input('nameGeneralLedgerAccount')),
            'abvGeneralLedgerAccount' => strtoupper($this->input('abvGeneralLedgerAccount')),
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
        $id = $requests['general_ledger_account'];
        // dd($id);
        return [
            'nameGeneralLedgerAccount' => ['required', 'max:50', Rule::unique('master_general_ledger_accounts')->whereNull('deleted_at')->ignore($id)],
            'abvGeneralLedgerAccount' => ['required', 'max:25', Rule::unique('master_general_ledger_accounts')->whereNull('deleted_at')->ignore($id)],
            'typeAccount' => 'required|in:AK,PS,PD,BY,LL',
            'specialAccount' => 'required|in:KS,BK,RE,PCY,GENERAL',
        ];
    }

    public function messages()
    {
        return [
            'typeAccount.in' => 'The selected type account is invalid. Select between: AK, PS, PD, BY, or LL.',
            'specialAccount.in' => 'The selected special account is invalid. Select between: KS, BK, RE, PCY, or GENERAL.',
        ];
    }
}
