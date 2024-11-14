<?php

namespace App\Http\Requests\Master\Premix;

use App\Models\MasterPremix;
use App\Models\MasterPremixGroup;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class StoreMasterPremixRequest extends FormRequest
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
            'codePremixGroup' => 'required',
            'codePremix' => 'required|max:8'
        ]);

        $IdPremixGroup = MasterPremixGroup::where('codePremixGroup', $this->codePremixGroup)->first()->id;
        // 
        if ($IdPremixGroup) {
            $lenCodeGroup = strlen($this->codePremixGroup);
            if (strtoupper(substr($this->codePremix, 0, $lenCodeGroup)) !== $this->codePremixGroup) {
                $validator->errors()->add('codePremix', 'The first ' . $lenCodeGroup . ' digits of the product code must be identical to the group code.');

                throw new ValidationException($validator);
            }
        } else {
            $validator->errors()->add('codePremixGroup', 'Premix Group not Found');
            throw new ValidationException($validator);
        }
        // 
        $exists = MasterPremix::where('codePremix', $this->codePremix)->exists();

        if ($exists) {
            $validator->errors()->add('codePremix', 'Premix already exists');

            throw new ValidationException($validator);
        }


        $this->merge([
            'codePremix' => strtoupper($this->input('codePremix')),
            'namePremix' => strtoupper($this->input('namePremix')),
            'codePremixGroup' => $IdPremixGroup
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
            'codePremix' => 'required|max:8',
            'namePremix' => 'required|min:3',
            'unitOfMeasurement' => 'in:BKS,GR',
            'status' => 'in:Active,Non-Active',
            // 
            'codePremixGroup' => 'required'
        ];
    }
}
