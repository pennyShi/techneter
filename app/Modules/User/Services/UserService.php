<?php 
namespace App\Modules\User\Services;
use App\Modules\User\Services\UserServiceInterface;
use App\Modules\User\Repositories\Contracts\UserInfoRepositoryInterface;
use App\Exceptions\ServiceException;
use Validator;
use Session;

class UserService implements UserServiceInterface{

    const SESSION_USERINFO_KEY = 'userinfo';

    private $userInfoRepository;
    public function __construct(UserInfoRepositoryInterface $userInfoRepository)
    {
        $this->userInfoRepository = $userInfoRepository;
    }

    public function setSesstionUserinfo($userinfo)
    {
        return Session::put(self::SESSION_USERINFO_KEY,$userinfo);
    }

    public function destroySesstionUserinfo()
    {
        return Session::forget(self::SESSION_USERINFO_KEY);
    }

    public function getSessionUserinfo()
    {
        return Session::get(self::SESSION_USERINFO_KEY);
    }

    public function getUserInfoGenders()
    {
        return $this->userInfoRepository->getGenders();
    }

    public function getUserInfoDefaultReward()
    {
        return $this->userInfoRepository->getDefaultReward();
    }

    public function getUserInfoDefaultPostCount()
    {
        return $this->userInfoRepository->getDefaultPostCount();
    }

    public function getUserInfoDefaultPraiseCount()
    {
        return $this->userInfoRepository->getDefaultPraiseCount();
    }

    public function getUserInfoDefaultReplyCount()
    {
        return $this->userInfoRepository->getDefaultReplyCount();
    }

    public function verifyUserInfoGender($gender)
    {
        $rules = [
            'gender'    => 'required|in:'.implode(",", $this->getGenders()),
        ];
        $validator = Validator::make(['gender'=>$gender], $rules);
        return $validator->passes();
    }

    public function verifyUserInfoUserPassportIdUnique($userPassportId)
    {   
        $rules = [
            'user_passport_id' => 'required|integer|userPassportIdUnique',
        ];
        Validator::extend('userPassportIdUnique', function($attribute, $value, $parameters, $validator) { 
            $userinfo = $this->getUserInfoByUserPassportId($value);
            if($userinfo)
            {
                return false;
            }else{
                return true;
            }
        });
        $validator = Validator::make(['user_passport_id'=>$userPassportId], $rules);
        return $validator->passes();
    }

    public function verifyUserinfoNameUnique($name)
    {   
        $rules = [
            'name'    => 'required|string|nameUnique',
        ];
        Validator::extend('nameUnique', function($attribute, $value, $parameters, $validator) { 
            $userinfos = $this->getUserInfoByEqualName($value);
            if(count($userinfos)>0)
            {
                return false;
            }else{
                return true;
            }
        });
        $validator = Validator::make(['name'=>$name], $rules);
        return $validator->passes();
    }

    public function verifyUserInfoUserPassportIdExist($userPassportId)
    {   
        $rules = [
            'user_passport_id'    => 'required|integer|userPassportIdExist',
        ];
        Validator::extend('userPassportIdExist', function($attribute, $value, $parameters, $validator) { 
            $userinfo = $this->getUserInfoByUserPassportId($value);
            if($userinfo)
            {
                return true;
            }else{
                return false;
            }
        });
        $validator = Validator::make(['user_passport_id'=>$userPassportId], $rules);
        return $validator->passes();
    }

    public function getUserInfoByUserPassportId($userPassportId)
    {
        $validator = $this->userInfoRepository->getFilterValidator(['user_passport_id'=>$userPassportId]);
        if($validator->passes()) {
            return $this->userInfoRepository->getByUserPassportId($userPassportId);
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function getUserInfoByUserPassportIds(array $userPassportIds)
    {
        $validator = $this->userInfoRepository->getFilterValidator(['user_passport_ids'=>$userPassportIds]);
        if($validator->passes()) {
            $fileds = [];
            $fileds['user_passport_ids'] = $userPassportIds;
            return $this->userInfoRepository->get($fileds,[],0,0);
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function getUserInfoByEqualName($name)
    {
        $validator = $this->userInfoRepository->getFilterValidator(['equal_name'=>$name]);
        if($validator->passes()) {
            
            $fileds = [];
            $fileds['equal_name'] = $name;
            $userInfos = $this->userInfoRepository->get($fileds);
            return $userInfos;

        }else{  
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function storeUserInfo($userPassportId, $data)
    {
        $storeData = [];
        if(!isset($data['post_count']))
        {
            $data['post_count'] = $this->getUserInfoDefaultPostCount();
        }

        if(!isset($data['praise_count']))
        {
            $data['praise_count'] = $this->getUserInfoDefaultPraiseCount();
        }

        if(!isset($data['reply_count']))
        {
            $data['reply_count'] = $this->getUserInfoDefaultReplyCount();
        }

        if(!isset($data['reward']))
        {
            $data['reward'] = $this->getUserInfoDefaultReward();
        }

        $storeData['user_passport_id'] = $userPassportId;
        $storeData += $data;
        $validator = $this->userInfoRepository->getStoreValidator($storeData);
        $rules = $validator->getRules();
        $rules['user_id'][] = 'verifyUserinfoUidUnique';
        $validator->setRules($rules);
        $validator->addExtension('verifyUserinfoUidUnique', function($attribute, $value, $parameters, $validator) {
            return $this->verifyUserinfoUidUnique($value);
        });

        if($validator->passes()) {
            $userInfo =  $this->userInfoRepository->store($storeData);
            return $userInfo;

        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function updateUserInfoByUserPassportId($userPassportId,$updateData)
    {
        $validationData = [];
        $validationData['user_passport_id'] = $userPassportId;
        $validationData += $updateData;
        $validator = $this->userInfoRepository->getUpdateValidator($validationData);
        $rules = $validator->getRules();
        $rules['user_passport_id'][] = 'verifyUserPassportIdUpdate';
        $validator->setRules($rules);
        $validator->addExtension('verifyUserPassportIdUpdate', function($attribute, $value, $parameters, $validator) {
            return $this->verifyUserInfoUserPassportIdExist($value);
        });

        if($validator->passes()) {
            $userInfo =  $this->userInfoRepository->updateByUserPassportId($userPassportId,$updateData);
            return $userInfo;
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function incrByUserInfoPostCount($userPassportId,$count=1)
    {
        $validatorData = ['user_passport_id' => $userPassportId,'count' => $count];
        $rules = [
            'user_passport_id' => 'required|verifyUserInfoUserPassportIdExist',
            'count' => 'required|integer|min:1',
        ];
        Validator::extend('verifyUserInfoUserPassportIdExist', function($attribute, $value, $parameters, $validator) {
            return $this->verifyUserInfoUserPassportIdExist($value);
        });
        $validator = Validator::make($validatorData, $rules);
        if ($validator->passes()){
            return $this->userInfoRepository->incrByPostCount($userPassportId,$count);
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function decrByUserInfoPostCount($userPassportId,$count=1)
    {
        $validatorData = ['user_passport_id' => $userPassportId,'count' => $count];
        $rules = [
            'user_passport_id' => 'required|verifyUserInfoUserPassportIdExist',
            'count' => 'required|integer|min:1',
        ];
        Validator::extend('verifyUserInfoUserPassportIdExist', function($attribute, $value, $parameters, $validator) {
            return $this->verifyUserInfoUserPassportIdExist($value);
        });
        $validator = Validator::make($validatorData, $rules);
        if ($validator->passes()){
            return $this->userInfoRepository->decrByPostCount($userPassportId,$count);
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function incrByUserInfoPraiseCount($userPassportId,$count=1)
    {
        $validatorData = ['user_passport_id' => $userPassportId,'count' => $count];
        $rules = [
            'user_passport_id' => 'required|verifyUserInfoUserPassportIdExist',
            'count' => 'required|integer|min:1',
        ];
        Validator::extend('verifyUserInfoUserPassportIdExist', function($attribute, $value, $parameters, $validator) {
            return $this->verifyUserInfoUserPassportIdExist($value);
        });
        $validator = Validator::make($validatorData, $rules);
        if ($validator->passes()){
            return $this->userInfoRepository->incrByPraiseCount($userPassportId,$count);
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function decrByUserInfoPraiseCount($userPassportId,$count=1)
    {
        $validatorData = ['user_passport_id' => $userPassportId,'count' => $count];
        $rules = [
            'user_passport_id' => 'required|verifyUserInfoUserPassportIdExist',
            'count' => 'required|integer|min:1',
        ];
        Validator::extend('verifyUserInfoUserPassportIdExist', function($attribute, $value, $parameters, $validator) {
            return $this->verifyUserInfoUserPassportIdExist($value);
        });
        $validator = Validator::make($validatorData, $rules);
        if ($validator->passes()){
            return $this->userInfoRepository->decrByPraiseCount($userPassportId,$count);
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function incrByUserInfoReplyCount($userPassportId,$count=1)
    {
        $validatorData = ['user_passport_id' => $userPassportId,'count' => $count];
        $rules = [
            'user_passport_id' => 'required|verifyUserInfoUserPassportIdExist',
            'count' => 'required|integer|min:1',
        ];
        Validator::extend('verifyUserInfoUserPassportIdExist', function($attribute, $value, $parameters, $validator) {
            return $this->verifyUserInfoUserPassportIdExist($value);
        });
        $validator = Validator::make($validatorData, $rules);
        if ($validator->passes()){
            return $this->userInfoRepository->incrByReplyCount($userPassportId,$count);
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function decrByUserInfoReplyCount($userPassportId,$count=1)
    {
        $validatorData = ['user_passport_id' => $userPassportId,'count' => $count];
        $rules = [
            'user_passport_id' => 'required|verifyUserInfoUserPassportIdExist',
            'count' => 'required|integer|min:1',
        ];
        Validator::extend('verifyUserInfoUserPassportIdExist', function($attribute, $value, $parameters, $validator) {
            return $this->verifyUserInfoUserPassportIdExist($value);
        });
        $validator = Validator::make($validatorData, $rules);
        if ($validator->passes()){
            return $this->userInfoRepository->decrByReplyCount($userPassportId,$count);
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }





}