<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReportRequest extends FormRequest
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
            'user_id' => 'exists:users,id',
            'closed' => 'boolean',
            'reason' => 'max:255',
            'post_id' => [
                'bail',
                function ($attribute, $value, $fail) {
                    if (request()->has($attribute) === request()->filled('comment_id')) {
                        return $fail('Only 1 of the two is allowed');
                    }
                }],
            'comment_id' => ['required_without:post_id','nullable'],
        ];
    }
}
