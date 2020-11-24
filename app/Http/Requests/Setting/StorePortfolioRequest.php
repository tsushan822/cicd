<?php

namespace App\Http\Requests\Setting;

use App\Http\Requests\Request;
use App\Rules\UniqueCheckEncrypted;
use App\Zen\Setting\Model\Portfolio;

class StorePortfolioRequest extends Request
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
        $id = is_numeric($this -> segment(2)) ? $this -> segment(2) : null;
        if($id) {
            return [
                'name' => ['required', 'max:255', new UniqueCheckEncrypted(new Portfolio, $id)],
                'long_name' => ['required', 'max:255', new UniqueCheckEncrypted(new Portfolio, $id)],
            ];
        } else {
            return [
                'name' => ['required', 'max:255', new UniqueCheckEncrypted(new Portfolio)],
                'long_name' => ['required', 'max:255', new UniqueCheckEncrypted(new Portfolio)]
            ];
        }
    }

    public function messages()
    {
        return [
            'name.required' => "The short name field is required",
            'long_name.required' => "The description field is required"
        ];
    }

}
