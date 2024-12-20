<?php

namespace App\Http\Requests\Master\Account;

use App\Models\Master\MasterBalanceSheetAccount;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class StoreMasterGeneralLedgerAccountRequest extends FormRequest
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
            'numberGeneralLedgerAccount' => 'required|regex:/^\d+$/|max:8|min:6',
            'numberBalanceSheetAccount' => 'required|regex:/^\d+$/|max:8|min:6',
        ]);

        $numberBalanceSheetAccount = $this->input('numberBalanceSheetAccount');
        $cekNumberBalanceSheetAccount = MasterBalanceSheetAccount::where('numberBalanceSheetAccount', $numberBalanceSheetAccount)->firstOr(function () {
            return null;
        });

        $numberGeneralLedgerAccount = $this->input('numberGeneralLedgerAccount');
        if ($cekNumberBalanceSheetAccount) {
            if (substr($numberGeneralLedgerAccount, 0, 4) !== substr($this->input('numberBalanceSheetAccount'), 0, 4)) {
                $validator->errors()->add('numberGeneralLedgerAccount', '
                The first 4 digits must match the balance sheet account number entered.');
                throw new ValidationException($validator);
            }
        } else {
            $validator->errors()->add('numberBalanceSheetAccount', 'Number Balance Sheet Account not Found');
            throw new ValidationException($validator);
        }

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
        return [
            'numberGeneralLedgerAccount' => ['required', 'regex:/^\d+$/', 'min:6', 'max:8', Rule::unique('master_general_ledger_accounts')->whereNull('deleted_at')],
            'nameGeneralLedgerAccount' => ['required', 'max:50', Rule::unique('master_general_ledger_accounts')->whereNull('deleted_at')],
            'abvGeneralLedgerAccount' => ['required', 'max:25', Rule::unique('master_general_ledger_accounts')->whereNull('deleted_at')],
            'typeAccount' => 'required|in:AK,PS,PD,BY,LL',
            'specialAccount' => 'required|in:KS,BK,RE,PCY,GENERAL',
            'numberBalanceSheetAccount' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'numberGeneralLedgerAccount.regex' => 'Number Account only accept number.',
            'typeAccount.in' => 'The selected type account is invalid. Select between: AK, PS, PD, BY, or LL.',
            'specialAccount.in' => 'The selected special account is invalid. Select between: KS, BK, RE, PCY, or GENERAL.',
        ];
    }
}
