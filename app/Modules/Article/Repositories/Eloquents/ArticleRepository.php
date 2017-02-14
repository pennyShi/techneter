<?php
namespace App\Modules\Article\Repositories\Eloquents;
use App\Modules\Article\Repositories\Contracts\ArticleRepositoryInterface;
use App\Repositories\EloquentRepository;
use App\Repositories\OperateIdTrait;
use App\Modules\Article\Models\Article;
use App\Exceptions\RepositoryException;

class ArticleRepository extends EloquentRepository implements ArticleRepositoryInterface 
{    
    use OperateIdTrait;

    const DEFAULT_VIEW_COUNT = 0;

    public function __construct()
    {
        $articleModel = Article::getInstance();
        parent::__construct($articleModel);
    }

    protected function initFilterField()
    {
        $this->filterFields = ['id','ids','article_category_id'];
    }

    protected function initOrderField()
    {
        $this->orderFields = ['id_asc', 'id_desc','weight_asc', 'weight_desc','rand'];
    }

    protected function initValidatorRules()
    {
        $this->rules = [
            'STORE' => [
                'article_category_id'   => 'required|integer',
                'title'                 => 'required|string|max:200',
                'image'                 => 'required|url|max:200',
                'description'           => 'required|string|max:500',
                'content'               => 'required|string',
                'view_count'            => 'required|integer',
                'weight'                => 'required|integer',
            ],
            'UPDATE' => [
                'article_category_id'   => 'integer',
                'title'                 => 'string|max:200',
                'image'                 => 'url|max:200',
                'description'           => 'string|max:500',
                'content'               => 'string',
                'view_count'            => 'integer',
                'weight'                => 'integer',
            ],            
            'FILTERFIELD' => [
                'id'                    => 'integer',
                'ids'                   => 'array',
                'ids.*'                 => 'integer',
                'article_category_id'   => 'integer',
            ]
        ];
    }

    public function getDefaultViewCount()
    {
        return self::DEFAULT_VIEW_COUNT;
    }

    public function incrByViewCount($id,$viewCount = 1)
    {
        $attributes = [];
        $article = $this->getById($id);
        $attributes['view_count'] = $article->view_count + $viewCount;
        $article = $this->updateModel($attributes,$article);
        return $article;
    }

    public function decrByViewCount($id,$viewCount = 1)
    {
        $attributes = [];
        $article = $this->getById($id);
        $attributes['view_count'] = $article->view_count - $viewCount;
        $article = $this->updateModel($attributes,$article);
        return $article;
    }
}
