<?php

namespace App\Http\Controllers\Web;
use Illuminate\Routing\Controller as BaseController;
use Forum;
use Passport;
use User;
use Output;
use Request;

class IndexController extends BaseController
{
	public function index()
	{
		$fileds = [];
		$forumPosts = Forum::getForumPosts($fileds,'reply_count_desc',0,20);
		$forumPostArray = $forumPosts->toArray();
		$forumPostUserPassportIds =  array_unique(array_column($forumPostArray, 'user_passport_id'));
		$userInfos = User::getUserInfoByUserPassportIds($forumPostUserPassportIds);

		$data =[];
		$data['forumPosts'] = $forumPosts;
		$data['userInfos'] = $userInfos;
		return view('web/index/index',$data);
	}
}
