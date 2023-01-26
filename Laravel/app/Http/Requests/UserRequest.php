<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username' => 'max:255|required',
            'first_name' => 'max:255',
            'last_name' => 'max:255',
            'email' => 'max:255|required|email',
            'profile_picture' => 'max:255',
            'picture_frame' => 'max:255',
            'xp' => '',
        ];
    }
}
