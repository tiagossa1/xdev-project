<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSchoolClassRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' =>
                Rule::unique('school_classes')->where(function ($query) {
                    $query->where('name', $this->name)
                        ->where('school_id', $this->school_id);
                }),
            'school_id' => 'exists:schools,id'
        ];
    }

    public function messages() {
        return [
            'name.unique' => 'Combination of name & school_id is not unique',
        ];
    }
}
