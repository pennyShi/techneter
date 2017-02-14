<?php

namespace App\Http\Controllers\Web;
use Illuminate\Routing\Controller as BaseController;
use Output;
use Request;
use Socialite;
use Passport;
use User;

class PassportController extends BaseController
{
	public function qqLogin()
	{
		return Socialite::driver('qq')->redirect();
	}

	public function qqDoLogin()
	{
		$user = Socialite::driver('qq')->user();
		$socialiteTypes = Passport::getSocialiteTypes();

		$socialiteType = $socialiteTypes['qq'];
		$socialiteId = $user->id;
		$passport = Passport::socialiteLogin($socialiteType,$socialiteId);
		$userInfo = User::getUserInfoByUserPassportId($passport->id);
		if(!$userInfo)
		{
			$userInfoGenders = User::getUserInfoGenders();
			$original = $user->original;
			$storeUserInfoData = [];
			if(User::verifyUserinfoNameUnique($user->nickname))
			{
				$storeUserInfoData['name'] = $user->nickname;
			}else{
				$storeUserInfoData['name'] = $user->nickname.'_'.rand(1,9);
			}
			$storeUserInfoData['avatar'] = $user->avatar;
			if($original['gender'] == '男')
			{
				$storeUserInfoData['gender'] = $userInfoGenders['male'];
			}else{
				$storeUserInfoData['gender'] = $userInfoGenders['famale'];
			}
			$userInfo = User::storeUserInfo($passport->id,$storeUserInfoData);
		}

		User::setSesstionUserinfo($userInfo);
		return redirect('/');
	}

	public function logout()
	{
		Passport::logout();
		User::destroySesstionUserinfo();
		return redirect('/');
	}

}
