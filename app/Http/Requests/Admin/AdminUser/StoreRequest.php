<?php
namespace App\Http\Requests\Admin\AdminUser;
use Illuminate\Foundation\Http\FormRequest;
use Admin;
use DB;

class StoreRequest extends FormRequest
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
  
    protected function getValidatorInstance()
    {
        $validatorInstance = parent::getValidatorInstance();
        $validatorInstance->addExtension('verifyEmail', function($attribute, $value, $parameters, $validator) {
            return Admin::verifyStoreAdminUserEmail($value);
        });
        return $validatorInstance;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {        
        return [
            'email'      => 'verifyEmail',
            'password'   => 'required|string|max:20',
        ];
    }

    public function messages()
    {
        return [
            'email.verify_email'    => '该邮箱异常',
            'password.required'     => '请填写密码',    
            'password.string'       => '密码必须为字符串',
            'password.max'          => '密码长度必须在20个字符以内',
        ];
    }

}
