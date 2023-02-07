<?php

namespace App\Http\Requests\PhoneBook\Contact;

use Illuminate\Foundation\Http\FormRequest;

class ContactCreateRequest extends FormRequest
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
            'firstName' => 'required|string',
            'secondName' => 'nullable|string',
            'lastName' => 'required|string',
            'numbers' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'firstName.required' => 'Обязательно укажите Имя контакта',
            'lastName.required' => 'Обязательно укажите Фамилию контакта'
        ];
    }
}
