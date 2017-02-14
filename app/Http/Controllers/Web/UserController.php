<?php

namespace App\Http\Controllers\Web;
use Illuminate\Routing\Controller as BaseController;
use Forum;
use Passport;
use User;
use Output;
use Request;

class UserController extends BaseController
{
	public function show($userPassportId)
	{
		$fileds = [];
		$fileds['user_passport_id'] = $userPassportId;
		$order = 'id_desc';
		$userForumPosts = Forum::getForumPosts($fileds,$order,0,10);
		$userForumPostArray = $userForumPosts->toArray();
		$userForumPostIds = array_column($userForumPostArray, 'id');
		$userForumReplies = Forum::getForumReplies($fileds,$order,0,10);
		$userForumReplyArray = $userForumReplies->toArray();
		$userForumReplyPostIds = array_column($userForumReplyArray, 'forum_post_id');
		$userForumPraises = Forum::getForumPostPraises($fileds,$order,0,10);
		$userForumPraiseArray = $userForumPraises->toArray();
		$userForumPraisePostIds = array_column($userForumPraiseArray, 'forum_post_id');
		$forumPostIds = array_unique(array_merge($userForumPostIds,$userForumReplyPostIds,$userForumPraisePostIds)) ;
		$forumPosts = Forum::getForumPostByIds($forumPostIds);
		$userInfo = User::getUserInfoByUserPassportId($userPassportId);

		$passport = Passport::user();

		$data =[];
		$data['userForumPosts']   = $userForumPosts;
		$data['userForumReplies'] = $userForumReplies;
		$data['userForumPraises'] = $userForumPraises;
		$data['forumPosts'] 	  = $forumPosts;
		$data['userInfo']		  = $userInfo;
		$data['passport']		  = $passport;

		return view('web/user/show',$data);
	}

	public function reward()
	{
		$passport = Passport::user();
		$userPassportId = $passport->id;
		$userInfo = User::getUserInfoByUserPassportId($userPassportId);

		$data = [];
		$data['userInfo'] = $userInfo;
		return view('web/user/reward',$data);
	}

	public function updateReward()
	{
		$reward = Request::input('reward');
		$passport = Passport::user();
		$updateData = [];
		$updateData['reward'] = $reward;
		User::updateUserInfoByUserPassportId($passport->id,$updateData);
		
		return Output::success();
	}

	public function info()
	{
		$passport = Passport::user();
		$userPassportId = $passport->id;
		$userInfo = User::getUserInfoByUserPassportId($userPassportId);
		$userInfoGenders = User::getUserInfoGenders();

		$data = [];
		$data['userInfo'] = $userInfo;
		$data['userInfoGenders'] = $userInfoGenders;
		return view('web/user/info',$data);
	}

	public function updateInfo()
	{
		$avatar = Request::input('avatar');
		$name = Request::input('name');
		$gender = Request::input('gender');

		$passport = Passport::user();
		$updateData = [];
		$updateData['avatar'] = $avatar;
		$updateData['name'] = $name;
		$updateData['gender'] = $gender;
		User::updateUserInfoByUserPassportId($passport->id,$updateData);

		return Output::success();
	}

}
