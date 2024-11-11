<?php

namespace App\Http\Requests\Master\Product;

use App\Models\MasterProduct;
use App\Models\MasterProductGroup;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
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

        $IdProductGroup = MasterProductGroup::where('codeProductGroup', $this->codeProductGroup)->first()->id;
        // 
        if ($IdProductGroup) {
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
        $exists = MasterProduct::where('codeProduct', $this->codeProduct)->exists();

        if ($exists) {
            $validator->errors()->add('codeProduct', 'Product already exists');

            throw new ValidationException($validator);
        }


        $this->merge([
            'codeProduct' => strtoupper($this->input('codeProduct')),
            'nameProduct' => strtoupper($this->input('nameProduct')),
            'codeProductGroup' => $IdProductGroup
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
            'codeProduct' => 'required|max:8',
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
