<?php

namespace App\Http\Requests\Master\Account;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class StoreMasterBalanceSheetAccountRequest extends FormRequest
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
            'numberBalanceSheetAccount' => 'required|regex:/^\d+$/|max:8|min:6',
            'characteristicAccount' => 'required|in:Header,Total,Account',
        ]);

        $numberBalanceSheetAccount = $this->input('numberBalanceSheetAccount');
        $characteristicAccount = $this->input('characteristicAccount');

        if (substr($numberBalanceSheetAccount, -4) !== '9999' && $characteristicAccount === 'Total') {
            $validator->errors()->add('numberBalanceSheetAccount', 'Sorry, we only accept accounts with the Total type, where the last 4 digits must be 9999.');
            throw new ValidationException($validator);
        }

        if (substr($numberBalanceSheetAccount, -4) !== '0000' && $characteristicAccount === 'Header') {
            $validator->errors()->add('numberBalanceSheetAccount', 'Sorry, we only accept accounts with the Header type, where the last 4 digits must be 0000.');
            throw new ValidationException($validator);
        }

        $this->merge([
            'nameBalanceSheetAccount' => strtoupper($this->input('nameBalanceSheetAccount')),
            'abvBalanceSheetAccount' => strtoupper($this->input('abvBalanceSheetAccount')),
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
            'numberBalanceSheetAccount' => ['required', 'regex:/^\d+$/', 'min:6', 'max:8', Rule::unique('master_balance_sheet_accounts')->whereNull('deleted_at')],
            'nameBalanceSheetAccount' => ['required', 'max:50', Rule::unique('master_balance_sheet_accounts')->whereNull('deleted_at')],
            'abvBalanceSheetAccount' => ['required', 'max:25', Rule::unique('master_balance_sheet_accounts')->whereNull('deleted_at')],
            'characteristicAccount' => 'required|in:Header,Total,Account',
            'typeAccount' => 'required|in:AK,PS,PD,BY,LL',
            'specialAccount' => 'required|in:KS,BK,RE,PCY,GENERAL',
        ];
    }

    public function messages()
    {
        return [
            'numberBalanceSheetAccount.regex' => 'Number Account only accept number.',
            'characteristicAccount.in' => 'The selected characteristic account is invalid. Select between: Header, Account, or Total.',
            'typeAccount.in' => 'The selected type account is invalid. Select between: AK, PS, PD, BY, or LL.',
            'specialAccount.in' => 'The selected special account is invalid. Select between: KS, BK, RE, PCY, or GENERAL.',
        ];
    }
}
