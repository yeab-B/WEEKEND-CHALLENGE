<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
  
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'name is required',
            'name.string' => 'name must be a string',
            'name.max' => 'name must be less than 255 characters',
            'email.required' => 'email is required',
            'email.string' => 'email must be a string',
            'email.email' => 'email must be a valid email address',
            'email.max' => 'email must be less than 255 characters',
            'email.unique' => 'email must be unique',
            'password.required' => 'password is required',
            'password.string' => 'password must be a string',
            'password.min' => 'password must be at least 8 characters',
            'password.confirmed' => 'password confirmation does not match',
            'role.required' => 'role is required',
            'role.exists' => 'role does not exist',
        ];
    }
}