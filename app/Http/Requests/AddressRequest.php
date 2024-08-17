<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title'=>'required|max:30|min:3|unique:addresses',
            'address'=>'required|max:300|min:5|unique:addresses',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
