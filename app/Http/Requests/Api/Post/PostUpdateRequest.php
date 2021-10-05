<?php

namespace App\Http\Requests\Api\Post;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class PostUpdateRequest extends FormRequest
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
    public function rules(Request $request)
    {
        $rules = [
            'title' => ['required', 'max:255'],
            'body' => ['required'],
        ];

        if ($request->has('user_id')) {
            $rules = $rules + array('user_id' => ['numeric']);
        }

        return $rules;
    }
}
