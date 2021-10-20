<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'title' => [
                'required',
                Rule::unique('posts')->where(function ($query) {
                    $query->where('title', $this->title)
                        ->where('user_id', $this->user_id);
                }),
                'max:20', 'min:7'
            ],
            'description' => ['required', 'max:255', 'min:2'],
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

