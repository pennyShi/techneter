<?php 
namespace App\Modules\Passport\Services;
use App\Modules\Passport\Services\PassportServiceInterface;
use App\Modules\Passport\Repositories\Contracts\UserPassportRepositoryInterface;
use App\Exceptions\ServiceException;
use Validator;
use Auth;
use Socialite;

class PassportService implements PassportServiceInterface{

    private $userPassportRepository;
    public function __construct(UserPassportRepositoryInterface $userPassportRepository)
    {
        $this->userPassportRepository = $userPassportRepository;
    }

    public function getSocialiteTypes()
    {
        return $this->userPassportRepository->getSocialiteTypes();
    }

    public function socialiteLogin($socialiteType,$socialiteId,$remember=true)
    {
        $validatorData = [];
        $validatorData['socialite_type'] = $socialiteType;
        $validatorData['socialite_id']   = $socialiteId;
        $validator = $this->userPassportRepository->getFilterValidator($validatorData);
        if($validator->passes()) {

            if (Auth::attempt(['socialite_type' => $socialiteType, 'socialite_id' => $socialiteId, 'password' => $socialiteId],$remember)) {
                return Auth::user();
            }else{
                $password = bcrypt($socialiteId);
                $userPassportData = [
                    'socialite_type'    => $socialiteType,
                    'socialite_id'      => $socialiteId,
                    'password'          => $password,
                ];
                $userPassport = $this->userPassportRepository->store($userPassportData);
                Auth::login($userPassport,$remember);
                return Auth::user();
            }

        }else{  
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function logout()
    {
        return Auth::logout();
    }

    public function check()
    {
        if($this->user())
        {
            return true;
        }else{
            return false;
        }
    }

    public function user()
    {
        return Auth::user();
    }
}