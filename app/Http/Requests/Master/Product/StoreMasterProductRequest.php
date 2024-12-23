<?php

namespace App\Http\Requests\Master\Product;

use App\Models\Master\MasterProduct;
use App\Models\Master\Product\MasterProductGroup;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class StoreMasterProductRequest extends FormRequest
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
            'codeProductGroup' => 'required',
            'codeProduct' => 'required|max:8'
        ]);
        // 
        $cekProductGroup = MasterProductGroup::where('codeProductGroup', $this->codeProductGroup)->firstOr(function () {
            return null;
        });
        // 
        if ($cekProductGroup) {
            $lenCodeGroup = strlen($this->codeProductGroup);
            if (strtoupper(substr($this->codeProduct, 0, $lenCodeGroup)) !== $this->codeProductGroup) {
                $validator->errors()->add('codeProduct', 'The first ' . $lenCodeGroup . ' digits of the product code must be identical to the group code.');

                throw new ValidationException($validator);
            }
        } else {
            $validator->errors()->add('codeProductGroup', 'Product Group not Found');
            throw new ValidationException($validator);
        }
        // 

        $this->merge([
            'codeProduct' => strtoupper($this->input('codeProduct')),
            'nameProduct' => strtoupper($this->input('nameProduct')),
            'codeProductGroup' => strtoupper($this->input('codeProductGroup')),
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
            'codeProduct' => ['required', Rule::unique('master_products')->whereNull('deleted_at')],
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
            'codeProductGroup' => 'required'
        ];
    }
}
