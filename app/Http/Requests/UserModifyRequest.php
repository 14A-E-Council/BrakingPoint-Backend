<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserModifyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => 'max:255|required',
            'first_name' => 'max:255',
            'last_name' => 'max:255',
        ];
    }
}

?>