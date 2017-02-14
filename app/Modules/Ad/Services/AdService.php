<?php 
namespace App\Modules\Ad\Services;
use App\Modules\Ad\Services\AdServiceInterface;
use App\Modules\Ad\Repositories\Contracts\AdRepositoryInterface;
use App\Exceptions\ServiceException;
use Validator;

class AdService implements AdServiceInterface{

    const LOCATIONS = [
        'index_collection'      => 1,
        'forum_index_side'      => 2,
        'forum_post_create'     => 3,
        'forum_category_side'   => 4,
        'forum_detail_side'     => 5,      
        'article_index_slide'   => 6,
        'article_index_side'    => 7,
        'article_detail_side'   => 8,
    ];

    const _LOCATIONS = [
        1 => '首页栏目集合',
        2 => '论坛首页侧边栏',
        3 => '论坛发帖侧边栏',        
        4 => '论坛分类侧边栏',
        5 => '论坛详情侧边栏',
        6 => '文章首页幻灯片',
        7 => '文章首页侧边栏',
        8 => '文章详情侧边栏',
    ];

    private $adRepository;

    public function __construct(AdRepositoryInterface $adRepository)
    {
    	$this->adRepository = $adRepository;
    }

    public function getAdLocations()
    {
        return self::LOCATIONS;
    }

    public function getAdTransLocations()
    {
        return self::_LOCATIONS;
    }

    public function verifyAdId($id)
    {
        $rules = [
            'id'    => 'required|integer|exists:ads,id,deleted_at,NULL',
        ];
        $validator = Validator::make(['id'=>$id], $rules);
        return $validator->passes();
    }

    public function getAdById($id)
    {
        $ad = $this->adRepository->getById($id);
        return $ad;
    }

    public function getPositionByIds(array $positionIds)
    {
        $ads = $this->adRepository->getByIds($positionIds);
        return $positions;
    }

    public function getAdPaginate(array $fileds=array(),$order='',$limit=20)
    {
        $validationData = [];
        $validationData['order'] = $order;
        $validationData += $fileds;
        $validator = $this->adRepository->getFilterValidator($getAdminData);
        $rules = $validator->getRules();
        $rules['order'][] = 'in:'.implode(',', $this->adRepository->getOrderFields());
        $validator->setRules($rules);
        if ($validator->passes()){
            $adPaginate = $this->adRepository->paginate($fileds,[$order],$limit);
            return $adPaginate;
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function getAdByLocation($location)
    {
        $fileds = [];
        $fileds['location'] = $location;
        $order = 'weight_desc';
        return $this->getAds($fileds,$order,0,0);
    }

    public function getAds(array $fileds=array(),$order='weight_desc',$offset=0,$limit=20)
    {
        $validationData = [];
        $validationData['order'] = $order;
        $validationData += $fileds;
        $validator = $this->adRepository->getFilterValidator($validationData);
        $rules = $validator->getRules();
        $rules['order'][] = 'in:'.implode(',', $this->adRepository->getOrderFields());
        $validator->setRules($rules);
        if ($validator->passes()){
            $ads = $this->adRepository->get($fileds,[$order],$offset,$limit);
            return $ads;
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function storeAd($storeData)
    {
        $validator = $this->adRepository->getStoreValidator($storeData); 
        if($validator->passes())
        {
            $ad = $this->adRepository->store($storeData);
            return $ad;
        }else{
            $messages = $validator->messages($storeData);
            throw new ServiceException($messages);
        } 
    }

    public function updateAd($id,array $updateData)
    {
        $validatorData = [];
        $validatorData += $updateData;
        $validatorData['id'] = $id;    
        $validator = $this->adRepository->getUpdateValidator($validatorData);
        $rules = $validator->getRules();
        $rules['id'][] = 'verifyAdId';        
        $validator->setRules($rules);
        $validator->addExtension('verifyAdId', function($attribute, $value, $parameters, $validator) {
            return $this->verifyAdId($value);
        });
        if ($validator->passes()){
            $ad = $this->adRepository->updateById($id,$updateData);
            return $ad;
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function destroyAd($id)
    {
        $validationData = [];
        $validationData['id'] = $id;
        $rules = [
            'id' => 'required|verifyAdId',
        ];
        Validator::extend('verifyAdId', function($attribute, $value, $parameters, $validator) {
            return $this->verifyAdId($value);
        });
        $validator = Validator::make($validationData, $rules);
        if ($validator->passes()){
            return $this->adRepository->destroyById($id);
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

}