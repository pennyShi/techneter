<?php
namespace App\Modules\Forum\Repositories\Eloquents;
use App\Modules\Forum\Repositories\Contracts\ForumPostPraiseRepositoryInterface;
use App\Repositories\EloquentRepository;
use App\Repositories\OperateIdTrait;
use App\Modules\Forum\Models\ForumPostPraise;
use App\Exceptions\RepositoryException;

class ForumPostPraiseRepository extends EloquentRepository implements ForumPostPraiseRepositoryInterface 
{    
    use OperateIdTrait;

    public function __construct()
    {
        $forumPostPraiseModel = ForumPostPraise::getInstance();
        parent::__construct($forumPostPraiseModel);
    }

    protected function initFilterField()
    {
        $this->filterFields = ['id','ids','user_passport_id','forum_post_id'];
    }

    protected function initOrderField()
    {
        $this->orderFields = ['id_asc', 'id_desc'];
    }

    protected function initValidatorRules()
    {
        $this->rules = [
            'STORE' => [
                'user_passport_id'      => 'required|integer',
                'forum_post_id'         => 'required|integer',
            ],
            'UPDATE' => [
                'user_passport_id'      => 'integer',
                'forum_post_id'         => 'integer',
            ],            
            'FILTERFIELD' => [
                'id'                    => 'integer',
                'ids'                   => 'array',
                'ids.*'                 => 'integer',
                'user_passport_id'      => 'integer',
                'forum_post_id'         => 'integer',
            ]
        ];
    }

    public function getByUserPassportIdForumPostId($userPassportId,$forumPostId)
    {
        $fileds = [];
        $fileds['user_passport_id'] = $userPassportId;
        $fileds['forum_post_id'] = $forumPostId;
        return $this->getOne($fileds);
    }

    public function getCountByUserPassportId($userPassportId)
    {
        $fileds = [];
        $fileds['user_passport_id'] = $userPassportId;
        return $this->count($fileds);
    }

    public function getByUserPassportId($userPassportId)
    {
        $fileds = [];
        $fileds['user_passport_id'] = $userPassportId;
        return $this->get($fileds,['id_asc']);
    }

    public function getCountByForumPostId($forumPostId)
    {
        $fileds = [];
        $fileds['forum_post_id'] = $forumPostId;
        return $this->count($fileds);
    }

    public function getByForumPostId($forumPostId)
    {
        $fileds = [];
        $fileds['forum_post_id'] = $forumPostId;
        return $this->get($fileds,['id_asc']);
    }

}
