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
            'title' => ['required','max:50', 'min:2'],
            'description' => ['required', 'max:255', 'min:2'],
            'user_id' => ['required', 'exists:users,id'],
            'post_type_id' => ['required', 'exists:post_types,id'],
        ];
    }
}
