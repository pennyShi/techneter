<?php
namespace App\Modules\Article\Repositories\Eloquents;
use App\Modules\Article\Repositories\Contracts\ArticleCategoryRepositoryInterface;
use App\Repositories\EloquentRepository;
use App\Repositories\OperateIdTrait;
use App\Modules\Article\Models\ArticleCategory;
use App\Exceptions\RepositoryException;

class ArticleCategoryRepository extends EloquentRepository implements ArticleCategoryRepositoryInterface 
{    
    use OperateIdTrait;

    public function __construct()
    {
        $articleCategoryModel = ArticleCategory::getInstance();
        parent::__construct($articleCategoryModel);
    }

    protected function initFilterField()
    {
        $this->filterFields = ['id','ids'];
    }

    protected function initOrderField()
    {
        $this->orderFields = ['id_asc', 'id_desc','weight_asc', 'weight_desc'];
    }

    protected function initValidatorRules()
    {
        $this->rules = [
            'STORE' => [
                'name'     => 'required|string|max:100',
                'weight'   => 'required|integer',
            ],
            'UPDATE' => [
                'name'     => 'string|max:100',
                'weight'   => 'integer',
            ],            
            'FILTERFIELD' => [
                'id'        => 'integer',
                'ids'       => 'array',
                'ids.*'     => 'integer',    
            ]
        ];
    }

}
