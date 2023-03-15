<?php

namespace App\Http\Requests\customer;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'=>'required','string','max:255',
            'email'=>'required|string|max:255|email|unique:customer,email,'.$this->id,
            'password'=>'required','string','min:5',
            'phone'=>'required','int',
            'address'=>'required','string',
            'image'=>'required','string',
        ];
    }
}
