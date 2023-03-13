<?php

namespace App\Http\Requests\worker;

use Illuminate\Foundation\Http\FormRequest;

class WorkerReqest extends FormRequest
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
            'name'=>'required|string|max:255',
            'email'=>'required|string|max:255|email|unique:worker,email,'.$this->id,
            'password'=>'required|string|min:5',
            'phone'=>'required',
            'address'=>'required|string',
            'image'=>'required|string',
            'description'=>'required|string|max:255',
            'portifolio'=>'required|string|max:255',
        ];
    }
}
