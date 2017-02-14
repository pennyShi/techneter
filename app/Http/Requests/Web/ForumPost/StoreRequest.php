<?php

namespace App\Http\Requests\Web\ForumPost;
use Illuminate\Foundation\Http\FormRequest;
use Forum;
use Passport;
use Gate;

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
        $validatorInstance->addExtension('verifyForumCategoryId', function($attribute, $value, $parameters, $validator) {
            return Forum::verifyForumCategoryId($value);
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
            'title'                 => 'required|string|max:200',
            'forum_category_id'     => 'required|integer|verifyForumCategoryId',
            'content'               => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'title.required'                                => '请输入帖子标题',
            'title.string'                                  => '帖子标题必须为字符串',
            'title.max'                                     => '帖子标题最长200个字符',
            'forum_category_id.required'                    => '帖子分类异常',
            'forum_category_id.integer'                     => '帖子分类异常',
            'forum_category_id.verify_forum_category_id'    => '帖子分类异常',
            'content.required'                              => '您还没有填写帖子的内容',
            'content.string'                                => '帖子内容必须为字符串',
        ];
    }

}
