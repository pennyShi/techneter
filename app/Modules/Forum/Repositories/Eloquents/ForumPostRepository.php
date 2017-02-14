<?php
namespace App\Modules\Forum\Repositories\Eloquents;
use App\Modules\Forum\Repositories\Contracts\ForumPostRepositoryInterface;
use App\Repositories\EloquentRepository;
use App\Repositories\OperateIdTrait;
use App\Modules\Forum\Models\ForumPost;
use App\Exceptions\RepositoryException;

class ForumPostRepository extends EloquentRepository implements ForumPostRepositoryInterface 
{    
    use OperateIdTrait;

    const DEFAULT_VIEW_COUNT   = 0;
    const DEFAULT_PRAISE_COUNT = 0;
    const DEFAULT_REPLY_COUNT  = 0;

    public function __construct()
    {
        $forumPostModel = ForumPost::getInstance();
        parent::__construct($forumPostModel);
    }

    protected function initFilterField()
    {
        $this->filterFields = ['id','ids','user_passport_id','forum_category_id'];
    }

    protected function initOrderField()
    {
        $this->orderFields = ['id_asc', 'id_desc','view_count_asc', 'view_count_desc','reply_count_asc', 'reply_count_desc','praise_count_asc', 'praise_count_desc','weight_asc', 'weight_desc'];
    }

    protected function initValidatorRules()
    {
        $this->rules = [
            'STORE' => [
                'user_passport_id'      => 'required|integer',
                'forum_category_id'     => 'required|integer',
                'title'                 => 'required|string|max:200',
                'content'               => 'required|string',
                'view_count'            => 'required|integer',
                'praise_count'          => 'required|integer',
                'reply_count'           => 'required|integer',
                'weight'                => 'required|integer',
            ],
            'UPDATE' => [
                'user_passport_id'      => 'integer',
                'forum_category_id'     => 'integer',
                'title'                 => 'string|max:200',
                'content'               => 'string',
                'view_count'            => 'integer',
                'praise_count'          => 'integer',
                'reply_count'           => 'integer',
                'weight'                => 'integer',
            ],            
            'FILTERFIELD' => [
                'id'                => 'integer',
                'ids'               => 'array',
                'ids.*'             => 'integer',
                'user_passport_id'  => 'integer',
                'forum_category_id' => 'integer',
            ]
        ];
    }

    public function getDefaultViewCount()
    {
        return self::DEFAULT_VIEW_COUNT;
    }

    public function getDefaultPraiseCount()
    {
        return self::DEFAULT_PRAISE_COUNT;
    }

    public function getDefaultReplyCount()
    {
        return self::DEFAULT_REPLY_COUNT;
    }

    public function incrByViewCount($id,$viewCount = 1)
    {
        $attributes = [];
        $post = $this->getById($id);
        $attributes['view_count'] = $post->view_count + $viewCount;
        $post = $this->updateModel($attributes,$post);
        return $post;
    }

    public function decrByViewCount($id,$viewCount = 1)
    {
        $attributes = [];
        $post = $this->getById($id);
        $attributes['view_count'] = $post->view_count - $viewCount;
        $post = $this->updateModel($attributes,$post);
        return $post;
    }

    public function incrByPraiseCount($id,$praiseCount = 1)
    {
        $attributes = [];
        $post = $this->getById($id);
        $attributes['praise_count'] = $post->praise_count + $praiseCount;
        $post = $this->updateModel($attributes,$post);
        return $post;
    }

    public function decrByPraiseCount($id,$praiseCount = 1)
    {
        $attributes = [];
        $post = $this->getById($id);
        $attributes['praise_count'] = $post->praise_count - $praiseCount;
        $post = $this->updateModel($attributes,$post);
        return $post;
    }

    public function incrByReplyCount($id,$replyCount = 1)
    {
        $attributes = [];
        $post = $this->getById($id);
        $attributes['reply_count'] = $post->reply_count + $replyCount;
        $post = $this->updateModel($attributes,$post);
        return $post;
    }

    public function decrByReplyCount($id,$replyCount = 1)
    {
        $attributes = [];
        $post = $this->getById($id);
        $attributes['reply_count'] = $post->reply_count - $replyCount;
        $post = $this->updateModel($attributes,$post);
        return $post;
    }

}
