<?php

namespace App\Http\Controllers\Web;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Requests\Web\ForumPost\StoreRequest;
use Forum;
use Passport;
use User;
use Output;
use Request;

class ForumPostController extends BaseController
{
	public function index()
	{
		$order = Request::input('order','default');
		if($order == 'hot'){
			$postOrder = 'reply_count_desc';
		}elseif($order == 'praise'){
			$postOrder = 'praise_count_desc';
		}else{
			$postOrder = 'weight_desc';
		}

		$fileds = [];
		$forumPostPaginate = Forum::getForumPostPaginate($fileds,$postOrder);
		$forumPostCollection = $forumPostPaginate->getCollection();
		$forumPostArray = $forumPostCollection->toArray();
		$forumPostUserPassportIds =  array_unique(array_column($forumPostArray, 'user_passport_id'));
		$userInfos = User::getUserInfoByUserPassportIds($forumPostUserPassportIds);

		$data = [];
		$data['order'] = $order;
		$data['userInfos'] = $userInfos;
		$data['forumPostPaginate'] = $forumPostPaginate;
		$data['title'] = 'Techneter-创业者与互联网社区';
		$data['keywords'] = 'Techneter,创业,互联网人,技术,社区,创业,精选,有料,干货,有用,细节,内幕';
		$data['description'] = 'Techneter是运城最大的创业者和互联网人社区，致力于推动运城创业创新,以及互联网产品的推广与互联网经验技术交流分享的最靠谱的社区论坛。';
		return view('web/forum/index',$data);
	}

	public function category($forumCategoryId)
	{
		$order = Request::input('order','default');
		if($order == 'hot'){
			$postOrder = 'reply_count_desc';
		}elseif($order == 'praise'){
			$postOrder = 'praise_count_desc';
		}else{
			$postOrder = 'weight_desc';
		}

		$fileds = [];
		$fileds['forum_category_id'] = $forumCategoryId;
		$forumPostPaginate = Forum::getForumPostPaginate($fileds,$postOrder);
		$forumPostCollection = $forumPostPaginate->getCollection();
		$forumPostArray = $forumPostCollection->toArray();
		$forumPostUserPassportIds =  array_unique(array_column($forumPostArray, 'user_passport_id'));
		$userInfos = User::getUserInfoByUserPassportIds($forumPostUserPassportIds);

		$forumPostCategory = Forum::getForumCategoryById($forumCategoryId);

		$data = [];
		$data['order'] = $order;
		$data['userInfos'] = $userInfos;
		$data['forumPostPaginate'] = $forumPostPaginate;
		$data['title'] = 'Techneter-'.$forumPostCategory->name.'社区';
		$data['keywords'] = 'Techneter-'.$forumPostCategory->name.'社区';
		$data['description'] = 'Techneter-'.$forumPostCategory->name.'社区';
		return view('web/forum/category',$data);
	}

	public function show($forumPostId)
	{
		$forumPost = Forum::incrByForumPostViewCount($forumPostId);
		$forumReplies = Forum::getForumRepliesByForumPostId($forumPostId);
		$forumReplyArray = $forumReplies->toArray();
		$forumPostUserPassportIds =  array_unique(array_column($forumReplyArray, 'user_passport_id'));

		$forumPostPraises = Forum::getForumPostPraiseByForumPostId($forumPostId);
		$forumPostPraiseArray = $forumPostPraises->toArray();
		$forumPostPraiseUserPassportIds = array_unique(array_column($forumPostPraiseArray, 'user_passport_id'));

		$userPassportIds = array_unique(array_merge($forumPostUserPassportIds,$forumPostPraiseUserPassportIds));
		$userInfos = User::getUserInfoByUserPassportIds($userPassportIds);
		$forumPostUserInfo = User::getUserInfoByUserPassportId($forumPost->user_passport_id);

		$passport = Passport::user();
		if($passport)
		{
			$userPassportId = $passport->id;
		}else{
			$userPassportId = 0;
		}

		$data = [];
		$data['forumPost'] = $forumPost;
		$data['forumPostUserInfo'] = $forumPostUserInfo;	
		$data['forumReplies'] = $forumReplies;
		$data['forumPostPraises'] = $forumPostPraises;
		$data['userInfos'] = $userInfos;
		$data['forumPostPraiseUserPassportIds'] = $forumPostPraiseUserPassportIds;
		$data['passport'] = $passport;
		$data['userPassportId'] = $userPassportId;
		$data['passportUserInfo'] = User::getSessionUserinfo();

		$data['title'] = 'Techneter-'.$forumPost->title;
		$data['keywords'] = $forumPost->title;
		$data['description'] = $forumPost->title;
		return view('web/forum/show',$data);
	}

	public function create()
	{
		$forumCategories = Forum::getForumCategories([],'weight_desc',0,0);
		$data = [];
		$data['forumCategories'] = $forumCategories;
		return view('web/forum/create',$data);
	}

	public function store(StoreRequest $storeRequest)
	{
		$passport = Passport::user();
		$storeData = [];
		$storeData['user_passport_id'] = $passport->id;
		$storeData['forum_category_id'] = $storeRequest->input('forum_category_id');
		$storeData['title'] = $storeRequest->input('title');
		$storeData['content'] = $storeRequest->input('content');
		$forumPost = Forum::storeForumPost($storeData);
		User::incrByUserInfoPostCount($passport->id);

		$returnDara = [];
		$returnDara['forumPost'] = $forumPost->toArray();
		return Output::success($returnDara);
	}


}
