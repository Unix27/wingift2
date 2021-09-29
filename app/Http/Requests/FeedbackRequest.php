<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class FeedbackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'feedback_name' => 'required|min:2|max:255',
            'feedback_phone' => 'required|min:10|max:13',
            'feedback_email' => 'nullable|email'
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => 'Пожалуйста, заполните поле',
            'feedback_phone.min' => 'Номер телефона должен содержать от 10 до 13 символов',
            'feedback_phone.max' => 'Номер телефона должен содержать от 10 до 13 символов',
            'email' => 'Неверный формат',
            'feedback_name.min' => 'Имя должно содержать хотя бы 2 символа'
        ];
    }
}
