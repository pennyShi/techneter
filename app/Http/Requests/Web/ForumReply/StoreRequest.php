<?php

namespace App\Http\Requests\Web\ForumReply;
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
        $validatorInstance->addExtension('verifyForumPostId', function($attribute, $value, $parameters, $validator) {
            return Forum::verifyForumPostId($value);
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
            'forum_post_id'  => 'required|integer|verifyForumPostId',
            'content'        => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'forum_post_id.required'                => '帖子ID异常',
            'forum_post_id.integer'                 => '帖子ID异常',
            'forum_post_id.verify_forum_post_id'    => '帖子ID异常',
            'content.required'                      => '您还没有填写回复的内容',
            'content.string'                        => '回复内容必须为字符串',
        ];
    }

}
