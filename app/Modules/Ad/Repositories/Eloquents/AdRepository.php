<?php
namespace App\Modules\Ad\Repositories\Eloquents;
use App\Modules\Ad\Repositories\Contracts\AdRepositoryInterface;
use App\Repositories\EloquentRepository;
use App\Repositories\OperateIdTrait;
use App\Exceptions\RepositoryException;
use App\Modules\Ad\Models\Ad;

class AdRepository extends EloquentRepository implements AdRepositoryInterface 
{   
    use OperateIdTrait;

    public function __construct()
    {
        $adModel = Ad::getInstance();
        parent::__construct($adModel);
    }

    protected function initFilterField()
    {
        $this->filterFields = ['id','ids','location'];
    }

    protected function initOrderField()
    {
        $this->orderFields = ['id_asc', 'id_desc','weight_asc', 'weight_desc'];
    }

    protected function initValidatorRules()
    {
        $this->rules = [
            'STORE' => [
                'location'     => 'required|integer',
                'title'        => 'required|string|max:100',
                'description'  => 'required|string|max:500',
                'image'        => 'required|url|max:300',
                'url'          => 'required|url|max:300',
                'weight'       => 'required|integer',
            ],
            'UPDATE' => [
                'location'     => 'integer',
                'title'        => 'string|max:100',
                'description'  => 'string|max:500',         
                'image'        => 'url|max:300',
                'url'          => 'url|max:300',
                'weight'       => 'integer',
            ],            
            'FILTERFIELD' => [
                'id'                => 'integer',
                'ids'               => 'array',
                'ids.*'             => 'integer',
                'location'          => 'integer',
            ]
        ];
    }
}
