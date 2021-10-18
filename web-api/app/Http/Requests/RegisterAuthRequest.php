<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterAuthRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email|ends_with:@edu.atec.pt',
            'birth_date' => 'required',
            'password' => 'required|string|min:6',
            'district_id' => 'required|exists:districts,id',
            'user_type_id' => 'required|exists:user_types,id',
            'school_class_id' => 'required|exists:school_classes,id'
        ];
    }
}
