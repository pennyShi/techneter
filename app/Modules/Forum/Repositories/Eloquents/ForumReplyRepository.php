<?php
namespace App\Modules\Forum\Repositories\Eloquents;
use App\Modules\Forum\Repositories\Contracts\ForumReplyRepositoryInterface;
use App\Repositories\EloquentRepository;
use App\Repositories\OperateIdTrait;
use App\Modules\Forum\Models\ForumReply;
use App\Exceptions\RepositoryException;

class ForumReplyRepository extends EloquentRepository implements ForumReplyRepositoryInterface 
{    
    use OperateIdTrait;

    public function __construct()
    {
        $forumReplyModel = ForumReply::getInstance();
        parent::__construct($forumReplyModel);
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
                'user_passport_id'   => 'required|integer',
                'forum_post_id'      => 'required|integer',
                'content'            => 'required|string',
            ],
            'UPDATE' => [
                'user_passport_id'   => 'integer',
                'forum_post_id'      => 'integer',
                'content'            => 'string',
            ],            
            'FILTERFIELD' => [
                'id'                => 'integer',
                'ids'               => 'array',
                'ids.*'             => 'integer',
                'user_passport_id'  => 'integer',
                'forum_post_id'     => 'integer',

            ]
        ];
    }

    public function getCountByForumPostId($forumPostId)
    {
        $fileds = [];
        $fileds['forum_post_id'] = $forumPostId;
        return $this->count($fileds);
    }




}
