<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // FIXME: post_id and comment_id validation is failing when creating a report.
        return [
            'user_id' => 'required',
            //'post_id' => 'required_without:comment_id',
            //'comment_id' => 'required_without:post_id',
            'closed' => 'boolean',
            'reason' => ['required', 'max:255'],
            // 'post_id' => [
            //     'bail',
            //     function ($attribute, $value, $fail) {
            //         if (request()->has($attribute) === request()->filled('comment_id')) {
            //             return $fail('Only 1 of the two is allowed.');
            //         }
            //     }],
            'comment_id' => ['required_without:post_id','nullable'],
        ];
    }
}
