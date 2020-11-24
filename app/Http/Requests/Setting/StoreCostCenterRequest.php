<?php

namespace App\Http\Requests\Setting;


use App\Http\Requests\Request;
use App\Rules\UniqueCheckEncrypted;
use App\Zen\Setting\Model\CostCenter;

class StoreCostCenterRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        $rules = [
            'long_name' => 'required|max:255',
            'business_area' => 'max:255',
            'functional_area' => 'max:255',
            'person_responsible' => 'max:255'
        ];

        $id = is_numeric($this -> segment(2)) ? $this -> segment(2) : null;
        if($id) {
            $rules['short_name'] = ['required', 'max:255', new UniqueCheckEncrypted(new CostCenter, $id)];
        } else {
            $rules['short_name'] = ['required', 'max:255', new UniqueCheckEncrypted(new CostCenter)];
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'short_name.required' => 'The cost center name field is required.',
        ];
    }

}
