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
        return [
            'user_id' => 'required',
            'post_id' => 'required_without:comment_id',
            'comment_id' => 'required_without:post_id',
            'closed' => 'required',
            'reason' => 'required',
        ];
    }
}
