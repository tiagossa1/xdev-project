<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\OneOf;

class ReportRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required',
            //'post_id' => 'required_without:comment_id',
            //'comment_id' => 'required_without:post_id',
            'closed' => 'required|boolean',
            'reason' => ['required', 'max:255'],
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
