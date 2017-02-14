<?php
namespace App\Modules\Forum\Repositories\Eloquents;
use App\Modules\Forum\Repositories\Contracts\ForumCategoryRepositoryInterface;
use App\Repositories\EloquentRepository;
use App\Repositories\OperateIdTrait;
use App\Modules\Forum\Models\ForumCategory;
use App\Exceptions\RepositoryException;

class ForumCategoryRepository extends EloquentRepository implements ForumCategoryRepositoryInterface 
{    
    use OperateIdTrait;

    public function __construct()
    {
        $forumCategoryModel = ForumCategory::getInstance();
        parent::__construct($forumCategoryModel);
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
