<?php

namespace App\Http\Requests\Auth\Api;

use Illuminate\Foundation\Http\FormRequest;

class RegisterPostRequest extends FormRequest
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
        $attr = collect([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $input = collect($this->all());

        if ($input->has('address'))
            $attr->put('address', 'required|string|max:255');

        if ($input->has('phone'))
            $attr->put('phone', 'required|string|max:255');

        if ($input->has('birthday'))
            $attr->put('birthday', 'required|date|max:255');

        if ($input->has('info'))
            $attr->put('info', 'required|string|max:255');

        return $attr->toArray();
    }
}
