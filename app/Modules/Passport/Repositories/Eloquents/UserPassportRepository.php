<?php
namespace App\Modules\Passport\Repositories\Eloquents;
use App\Modules\Passport\Repositories\Contracts\UserPassportRepositoryInterface;
use App\Repositories\EloquentRepository;
use App\Repositories\OperateIdTrait;
use App\Modules\Passport\Models\UserPassport;
use App\Exceptions\RepositoryException;

class UserPassportRepository extends EloquentRepository implements UserPassportRepositoryInterface 
{    
    const SOCIALITE_TYPES = [
            'nil'   => 0,
            'qq'    => 1,
    ];

    use OperateIdTrait;

    public function __construct()
    {
        $userPassportModel = UserPassport::getInstance();
        parent::__construct($userPassportModel);
    }

    protected function initFilterField()
    {
        $this->filterFields = ['id','ids','socialite_type','socialite_id'];
    }

    protected function initOrderField()
    {
        $this->orderFields = ['id_asc', 'id_desc'];
    }

    protected function initValidatorRules()
    {
        $this->rules = [
            'STORE' => [
                'socialite_type'    => 'required|integer|in:'.implode(",", self::SOCIALITE_TYPES),
                'socialite_id'      => 'required|string',
                'password'          => 'required|string',
            ],
            'UPDATE' => [
                'socialite_type'    => 'integer|in:'.implode(",", self::SOCIALITE_TYPES),
                'socialite_id'      => 'string',
                'password'          => 'string',
            ],            
            'FILTERFIELD' => [
                'id'                    => 'integer',
                'ids'                   => 'array',
                'ids.*'                 => 'integer',
                'socialite_type'        => 'integer',                
                'socialite_id'          => 'string',
            ]
        ];
    }

    public function getSocialiteTypes()
    {
        return self::SOCIALITE_TYPES;
    }
    
}
