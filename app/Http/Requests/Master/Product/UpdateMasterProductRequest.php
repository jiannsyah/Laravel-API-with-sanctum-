<?php

namespace App\Http\Requests\Master\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMasterProductRequest extends FormRequest
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
            'nameProduct' => strtoupper($this->input('nameProduct')),
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
            'nameProduct' => 'required',
            'smallUnit' => 'required|in:BTR,PCS',
            'mediumUnit' => 'required|in:PACK',
            'largeUnit' => 'required|in:BAL,DUS',
            'smallUnitQty' => 'required|numeric|min:1',
            'mediumUnitQty' => 'required|numeric|min:1',
            'largeUnitQty' => 'required|numeric|min:1',
            'dryUnitWeight' => 'numeric|min:0',
            'wetUnitWeight' => 'numeric|min:0',
            'wholesalePrice' => 'numeric|min:0',
            'nonWholesalePrice' => 'numeric|min:0',
            'retailPrice' => 'numeric|min:0',
            'sellingPriceUnit' => 'required|in:BTR,PCS,PACK,BAL,DUS',
            'status' => 'required|in:Active,Non-Active',
            // 
        ];
    }
}
