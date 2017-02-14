<?php
namespace App\Modules\User\Repositories\Eloquents;
use App\Modules\User\Repositories\Contracts\UserInfoRepositoryInterface;
use App\Repositories\EloquentRepository;
use App\Repositories\OperateIdTrait;
use App\Modules\User\Models\UserInfo;
use App\Exceptions\RepositoryException;

class UserInfoRepository extends EloquentRepository implements UserInfoRepositoryInterface 
{    
    const GENDERS =[
        'male'    => 1,
        'famale'  => 2
    ];
    const DEFAULT_REWARD = '';
    const DEFAULT_POST_COUNT   = 0;
    const DEFAULT_PRAISE_COUNT = 0;
    const DEFAULT_REPLY_COUNT  = 0;
 
    use OperateIdTrait;

    public function __construct()
    {
        $userInfoModel = UserInfo::getInstance();
        parent::__construct($userInfoModel);
    }

    protected function initFilterField()
    {
        $this->filterFields = ['id','ids','user_passport_id','user_passport_ids','name','equal_name'];
    }

    protected function initOrderField()
    {
        $this->orderFields = ['id_asc', 'id_desc'];
    }

    protected function initValidatorRules()
    {
        $this->rules = [
            'STORE' => [
                'user_passport_id'     => 'required|integer',
                'name'                 => 'required|string|max:100',
                'avatar'               => 'required|url|max:300',
                'gender'               => 'required|integer|in:'.implode(',', self::GENDERS),
            ],
            'UPDATE' => [
                'user_passport_id'     => 'integer',
                'name'                 => 'string|max:100',
                'avatar'               => 'url|max:300',
                'gender'               => 'integer|in:'.implode(',', self::GENDERS),
            ],            
            'FILTERFIELD' => [
                'id'                    => 'integer',
                'ids'                   => 'array',
                'ids.*'                 => 'integer',
                'user_passport_id'      => 'integer',                
                'user_passport_ids'     => 'array',
                'user_passport_ids.*'   => 'integer',

            ]
        ];
    }

    public function getGenders()
    {
        return self::GENDERS;
    }

    public function getDefaultReward()
    {
        return self::DEFAULT_REWARD;
    }

    public function getDefaultPostCount()
    {
        return self::DEFAULT_POST_COUNT;
    }

    public function getDefaultPraiseCount()
    {
        return self::DEFAULT_PRAISE_COUNT;
    }

    public function getDefaultReplyCount()
    {
        return self::DEFAULT_REPLY_COUNT;
    }

    public function getByUserPassportId($userPassportId)
    {
        $fileds = [];
        $fileds['user_passport_id'] = $userPassportId;
        $userInfo = $this->getOne($fileds);
        return $userInfo;
    }

    public function updateByUserPassportId($userPassportId,array $attributes)
    {
        $userInfo = $this->getByUserPassportId($userPassportId);
        $userInfo = $this->updateModel($attributes,$userInfo);
        return $userInfo;
    }

    public function incrByPostCount($userPassportId,$postCount = 1)
    {
        $attributes = [];
        $userInfo = $this->getByUserPassportId($userPassportId);
        $attributes['post_count'] = $userInfo->post_count + $postCount;
        $userInfo = $this->updateModel($attributes,$userInfo);
        return $userInfo;
    }

    public function decrByPostCount($userPassportId,$postCount = 1)
    {
        $attributes = [];
        $userInfo = $this->getByUserPassportId($userPassportId);
        $attributes['post_count'] = $post->post_count - $postCount;
        $userInfo = $this->updateModel($attributes,$userInfo);
        return $userInfo;
    }

    public function incrByPraiseCount($userPassportId,$praiseCount = 1)
    {
        $attributes = [];
        $userInfo = $this->getByUserPassportId($userPassportId);
        $attributes['praise_count'] = $userInfo->praise_count + $praiseCount;
        $userInfo = $this->updateModel($attributes,$userInfo);
        return $userInfo;
    }

    public function decrByPraiseCount($userPassportId,$praiseCount = 1)
    {
        $attributes = [];
        $userInfo = $this->getByUserPassportId($userPassportId);
        $attributes['praise_count'] = $userInfo->praise_count - $praiseCount;
        $userInfo = $this->updateModel($attributes,$userInfo);
        return $userInfo;
    }

    public function incrByReplyCount($userPassportId,$replyCount = 1)
    {
        $attributes = [];
        $userInfo = $this->getByUserPassportId($userPassportId);
        $attributes['reply_count'] = $userInfo->reply_count + $replyCount;
        $userInfo = $this->updateModel($attributes,$userInfo);
        return $userInfo;
    }

    public function decrByReplyCount($userPassportId,$replyCount = 1)
    {
        $attributes = [];
        $userInfo = $this->getByUserPassportId($userPassportId);
        $attributes['reply_count'] = $userInfo->reply_count - $replyCount;
        $userInfo = $this->updateModel($attributes,$userInfo);
        return $userInfo;
    }


}
