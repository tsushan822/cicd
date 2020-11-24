<?php

namespace App\Http\Requests\Report;

use App\Rules\Report\RequireACheckBox;
use Illuminate\Foundation\Http\FormRequest;

class MultipleReportEmailRequest extends FormRequest
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
        return [
            'reportLibrary' => ['required', new RequireACheckBox],
            'start_date_new' => ['nullable', 'date'],
            'end_date_new' => ['nullable', 'date', 'after:start_date_new'],
        ];
    }

    public function messages()
    {
        return [
            'reportLibrary.required' => trans('master.Please check at least one check box.'),
            'end_date_new.after' => trans('master.The end date must be date after start date')
        ];

    }
}
