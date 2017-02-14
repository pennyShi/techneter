<?php

namespace App\Http\Requests\Admin\Index;
use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
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
        return [
            'email'     => 'required|email',
            'password'  => 'required|string',
        ];
    }

    public function messages()
    {   
        return [
            'email.required'    => '请输入登录邮箱',
            'email.email'       => '登录邮箱地址不合法',
            'password.required' => '请输入登录密码',
            'password.string'   => '登录密码不合法',
        ];
    }
}
