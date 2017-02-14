<?php

namespace App\Http\Requests\Web\ForumPostPraise;
use Illuminate\Foundation\Http\FormRequest;
use Forum;
use Passport;
use Gate;

class DestroyRequest extends FormRequest
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
        $validatorInstance->addExtension('verifyForumPostPraiseByUserPassportIdForumPostId', function($attribute, $value, $parameters, $validator) {
            $passport = Passport::user();
            return Forum::verifyForumPostPraiseByUserPassportIdForumPostId($value,$passport->id);
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
            'forum_post_id'  => 'required|integer|verifyForumPostId|verifyForumPostPraiseByUserPassportIdForumPostId',
        ];
    }

    public function messages()
    {
        return [
            'forum_post_id.required'    => '帖子ID异常',
            'forum_post_id.integer'     => '帖子ID异常',
            'forum_post_id.verify_forum_post_id'    => '帖子ID异常',
            'forum_post_id.verify_forum_post_praise_by_user_passport_id_forum_post_id'    => '您还没有赞过',
        ];
    }

}
