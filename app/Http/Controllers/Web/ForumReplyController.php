<?php

namespace App\Http\Controllers\Web;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Requests\Web\ForumReply\StoreRequest;
use Forum;
use Passport;
use User;
use Output;
use Request;

class ForumReplyController extends BaseController
{
	public function store(StoreRequest $storeRequest)
	{
		$passport = Passport::user();
		$storeData = [];
		$storeData['user_passport_id'] 	= $passport->id;
		$storeData['forum_post_id'] 	= $storeRequest->input('forum_post_id');
		$storeData['content'] 			= $storeRequest->input('content');
		$forumReply = Forum::storeForumReply($storeData);
		User::incrByUserInfoReplyCount($passport->id);
		$userInfo = User::getSessionUserinfo();

		$returnDara = [];
		$returnDara['forumReply'] = $forumReply->toArray();
		$returnDara['userInfo'] = $userInfo->toArray();
		return Output::success($returnDara);
	}


}
