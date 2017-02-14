<?php

namespace App\Http\Controllers\Web;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Requests\Web\ForumPostPraise\StoreRequest;
use App\Http\Requests\Web\ForumPostPraise\DestroyRequest;
use Forum;
use User;
use Output;
use Request;
use Passport;

class ForumPostPraiseController extends BaseController
{
	public function store(StoreRequest $storeRequest)
	{
		$passport = Passport::user();
		$storeData = [];
		$storeData['user_passport_id'] = $passport->id;
		$storeData['forum_post_id'] = $storeRequest->input('forum_post_id');
		$forumPostPraise = Forum::storeForumPostPraise($storeData);
		User::incrByUserInfoPraiseCount($passport->id);
		$userInfo = User::getSessionUserinfo();

		$returnDara = [];
		$returnDara['userInfo'] = $userInfo->toArray();
		return Output::success($returnDara);
	}

	public function destory(DestroyRequest $destroyRequest)
	{
		$passport = Passport::user();
		$forumPostId = $destroyRequest->input('forum_post_id');
		Forum::destroyForumPostPraise($passport->id,$forumPostId);
		User::decrByUserInfoPraiseCount($passport->id);
		$userInfo = User::getSessionUserinfo();

		$returnDara = [];
		$returnDara['userInfo'] = $userInfo->toArray();
		return Output::success($returnDara);
	}
}
