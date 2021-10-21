<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateFeedBackRequest extends FormRequest
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
            /*'description' => [
                'required',
                Rule::unique('feedback')->where(function ($query) {
                    $query->where('description', $this->description)
                        ->where('user_id', $this->user_id);
                }),
                'max:255'
            ],*/
            'description' => ['required', 'max:255'],
            'user_id' => ['required', 'exists:users,id'],
            'feedback_type_id' => ['required', 'exists:feedback_types,id']
        ];
    }

    public function messages() {
        return [
            'description.unique' => 'Combination of description & user_id is not unique',
        ];
    }
}
