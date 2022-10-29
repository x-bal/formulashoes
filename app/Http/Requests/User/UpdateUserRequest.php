<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'uid' => 'required|string|min:3|unique:users,uid,' . $this->user->id,
            'username' => 'required|string|min:3|unique:users,username,' . $this->user->id,
            'name' => 'required|string',
            'telepon' => 'required|numeric',
            'level' => 'required|string',
            'foto' => 'mimes:jpg, jpeg, png'
        ];
    }
}
