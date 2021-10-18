<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreatePostPhotoRequest extends FormRequest
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
            'url' => [
                'required',
                Rule::unique('post_photos')->where(function ($query) {
                    $query->where('url', $this->url)
                        ->where('post_id', $this->post_id);
                }),
                'max:20', 'min:2'
            ],
            'post_id' => ['required', 'exists:posts,id']
        ];
    }

    public function messages() {
        return [
            'url.unique' => 'Combination of url & post_id is not unique',
        ];
    }
}
