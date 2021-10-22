<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
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
            'title' => ['required', 'max:255'],
            'description' => ['required', 'max:255'],
            'user_id' => ['required', 'exists:users,id'],
            'post_type_id' => ['required', 'exists:post_types,id'],
        ];
    }

    public function messages() {
        return [
            'title.unique' => 'Combination of title & user_id is not unique',
        ];
    }
}

