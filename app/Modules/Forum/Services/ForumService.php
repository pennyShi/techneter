<?php 
namespace App\Modules\Forum\Services;
use App\Modules\Forum\Services\ForumServiceInterface;
use App\Modules\Forum\Repositories\Contracts\ForumCategoryRepositoryInterface;
use App\Modules\Forum\Repositories\Contracts\ForumPostRepositoryInterface;
use App\Modules\Forum\Repositories\Contracts\ForumReplyRepositoryInterface;
use App\Modules\Forum\Repositories\Contracts\ForumPostPraiseRepositoryInterface;
use App\Exceptions\ServiceException;
use Validator;
use Session;

class ForumService implements ForumServiceInterface{

    const POST_RANK_T = "2017-01-01 00:00:00";

    private $forumCategoryRepository;
    private $forumPostRepository;
    private $forumReplyRepository;
    private $forumPostPraiseRepository;

    public function __construct(ForumCategoryRepositoryInterface $forumCategoryRepository,
                                ForumPostRepositoryInterface $forumPostRepository , 
                                ForumReplyRepositoryInterface $forumReplyRepository ,
                                ForumPostPraiseRepositoryInterface $forumPostPraiseRepository)
    {
        $this->forumCategoryRepository = $forumCategoryRepository;
        $this->forumPostRepository = $forumPostRepository;
        $this->forumReplyRepository = $forumReplyRepository;
        $this->forumPostPraiseRepository = $forumPostPraiseRepository;
    }

    public function verifyForumCategoryId($id)
    {
        $rules = [
            'id' => 'required|integer|exists:forum_categories,id,deleted_at,NULL',
        ];
        $validator = Validator::make(['id'=>$id], $rules);
        return $validator->passes();
    }

    public function storeForumCategory(array $storeData)
    {
        $validator = $this->forumCategoryRepository->getStoreValidator($storeData);
        if ($validator->passes()){

            $forumCategory = $this->forumCategoryRepository->store($storeData);
            return $forumCategory;
        
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function updateForumCategory($id,array $updateData)
    {
        $validatorData = [];
        $validatorData += $updateData;
        $validatorData['id'] = $id;    
        $validator = $this->forumCategoryRepository->getUpdateValidator($validatorData);
        $rules = $validator->getRules();
        $rules['id'][] = 'verifyForumCategoryId';        
        $validator->setRules($rules);
        $validator->addExtension('verifyForumCategoryId', function($attribute, $value, $parameters, $validator) {
            return $this->verifyForumCategoryId($value);
        });
        if ($validator->passes()){

            $forumCategory = $this->forumCategoryRepository->updateById($id,$updateData);
            return $forumCategory;
        
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function destoryForumCategory($id)
    {
        $validationData = [];
        $validationData['id'] = $id;
        $rules = [
            'id'    => 'required|verifyForumCategoryId',
        ];
        Validator::extend('verifyForumCategoryId', function($attribute, $value, $parameters, $validator) {
            return $this->verifyForumCategoryId($value);
        });
        $validator = Validator::make($validationData, $rules);
        if($validator->passes()){
            return $this->forumCategoryRepository->destroyById($id);
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function getForumCategories(array $fileds=array(),$order='weight_desc',$offset=0,$limit=20)
    { 
        $data = [];
        $data['order'] = $order;
        $data += $fileds;
        $validator = $this->forumCategoryRepository->getFilterValidator($data);
        $rules = $validator->getRules();
        $rules['order'][] = 'in:'.implode(',', $this->forumCategoryRepository->getOrderFields());
        $validator->setRules($rules);
        if ($validator->passes()){
            $forumCategories = $this->forumCategoryRepository->get($fileds,[$order],$offset,$limit);
            return $forumCategories;
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function getForumCategoryPaginate(array $fileds=array(),$order='weight_desc',$limit=20)
    {
        $data = [];
        $data['order'] = $order;
        $data += $fileds;
        $validator = $this->forumCategoryRepository->getFilterValidator($data);
        $rules = $validator->getRules();
        $rules['order'][] = 'in:'.implode(',', $this->forumCategoryRepository->getOrderFields());
        $validator->setRules($rules);
        if ($validator->passes()){
            $forumCategoryPaginate = $this->forumCategoryRepository->paginate($fileds,[$order],$limit);
            return $forumCategoryPaginate;
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function getForumCategoryById($id)
    {
        $validator = $this->forumCategoryRepository->getFilterValidator(['id'=>$id]);
        if($validator->passes()) {
            return $this->forumCategoryRepository->getById($id);
        }else{  
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function getForumPostDefaultViewCount()
    {
        return $this->forumPostRepository->getDefaultViewCount();
    }

    public function getForumPostDefaultPraiseCount()
    {
        return $this->forumPostRepository->getDefaultPraiseCount();
    }

    public function getForumPostDefaultReplyCount()
    {
        return $this->forumPostRepository->getDefaultReplyCount();
    }

    public function storeForumPost($storeData)
    {
        if(!isset($storeData['view_count']))
        {
            $storeData['view_count'] = $this->getForumPostDefaultViewCount();
        }

        if(!isset($storeData['praise_count']))
        {
            $storeData['praise_count'] = $this->getForumPostDefaultViewCount();
        }

        if(!isset($storeData['reply_count']))
        {
            $storeData['reply_count'] = $this->getForumPostDefaultViewCount();
        }        

        if(!isset($storeData['weight']))
        {
            $storeData['weight'] = $this->getForumPostRank(date('Y-m-d H:i:s'),$storeData['reply_count']);
        }        

        $validator = $this->forumPostRepository->getStoreValidator($storeData);
        if ($validator->passes()){

            $forumPost = $this->forumPostRepository->store($storeData);
            return $forumPost;
        
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function updateForumPost($updateData)
    {
        $validatorData = [];
        $validatorData += $updateData;
        $validatorData['id'] = $id;    
        $validator = $this->forumCategoryRepository->getUpdateValidator($validatorData);
        $rules = $validator->getRules();
        $rules['id'][] = 'verifyForumPostId';        
        $validator->setRules($rules);
        $validator->addExtension('verifyForumPostId', function($attribute, $value, $parameters, $validator) {
            return $this->verifyForumPostId($value);
        });
        if ($validator->passes()){

            $forumPost = $this->forumPostRepository->updateById($id,$updateData);
            return $forumPost;

        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    protected function getForumPostRank($createdAt,$replyCount)
    {
        $rules = [
            'created_at'     => 'required|date_format:Y-m-d H:i:s',
            'reply_count'    => 'required|integer',
        ];
        $validator = Validator::make(['created_at'=>$createdAt,'reply_count'=>$replyCount], $rules);
        if($validator->passes()){

            $T  = strtotime(self::POST_RANK_T);
            $p  = $replyCount;
            $t1 = strtotime($createdAt);
            $rank = $p * ( 24 *3600 )/10 + ( $t1 - $T );
            return $rank;

        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function getForumPosts(array $fileds=array(),$order='weight_desc',$offset=0,$limit=20)
    {
        $data = [];
        $data['order'] = $order;
        $data += $fileds;
        $validator = $this->forumPostRepository->getFilterValidator($data);
        $rules = $validator->getRules();
        $rules['order'][] = 'in:'.implode(',', $this->forumPostRepository->getOrderFields());
        $validator->setRules($rules);
        if ($validator->passes()){
            $forumPosts = $this->forumPostRepository->get($fileds,[$order],$offset,$limit);
            return $forumPosts;
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function getForumPostPaginate(array $fileds=array(),$order='',$limit=20)
    {
        $data = [];
        $data['order'] = $order;
        $data += $fileds;
        $validator = $this->forumPostRepository->getFilterValidator($data);
        $rules = $validator->getRules();
        $rules['order'][] = 'in:'.implode(',', $this->forumPostRepository->getOrderFields());
        $validator->setRules($rules);
        if ($validator->passes()){
            $forumPostPaginate = $this->forumPostRepository->paginate($fileds,[$order],$limit);
            return $forumPostPaginate;
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function getForumPostByIds(array $ids,$order='weight_desc')
    {
        $fileds = [];
        $fileds['ids'] = $ids;
        return $this->getForumPosts($fileds,$order,0,0);
    }

    public function verifyForumPostId($id)
    {
        $rules = [
            'id'    => 'required|integer|exists:forum_posts,id,deleted_at,NULL',
        ];
        $validator = Validator::make(['id'=>$id], $rules);
        return $validator->passes();
    }

    public function verifyForumPostIds(array $ids)
    {
        $rules = [
            'ids'    => 'required|array',
            'ids.*'  => 'required|integer|exists:forum_posts,id,deleted_at,NULL',            
        ];
        $validator = Validator::make(['ids'=>$ids], $rules);
        return $validator->passes();
    }

    public function incrByForumPostViewCount($id,$count=1)
    {
        $validatorData = ['id' => $id,'count' => $count];
        $rules = [
            'id' => 'required|verifyForumPostId',
            'count' => 'required|integer|min:1',
        ];
        Validator::extend('verifyForumPostId', function($attribute, $value, $parameters, $validator) {
            return $this->verifyForumPostId($value);
        });
        $validator = Validator::make($validatorData, $rules);
        if ($validator->passes()){
            return $this->forumPostRepository->incrByViewCount($id,$count);
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function decrByForumPostViewCount($id,$count=1)
    {
        $validatorData = ['id' => $id,'count' => $count];
        $rules = [
            'id' => 'required|verifyForumPostId',
            'count' => 'required|integer|min:1',
        ];
        Validator::extend('verifyForumPostId', function($attribute, $value, $parameters, $validator) {
            return $this->verifyForumPostId($value);
        });
        $validator = Validator::make($validatorData, $rules);
        if ($validator->passes()){
            return $this->forumPostRepository->decrByViewCount($id,$count);
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function verifyForumReplyId($id)
    {
        $rules = [
            'id'    => 'required|integer|exists:forum_replies,id,deleted_at,NULL',
        ];
        $validator = Validator::make(['id'=>$id], $rules);
        return $validator->passes();
    }

    public function storeForumReply($replyData)
    {
        $validator = $this->forumReplyRepository->getStoreValidator($replyData);
        $rules = $validator->getRules();
        $rules['forum_post_id'][]  = 'verifyForumPostId';
        $validator->setRules($rules);       
        $validator->addExtension('verifyForumPostId', function($attribute, $value, $parameters, $validator) {
            return $this->verifyForumPostId($value);
        });

        if($validator->passes()){

            $forumReply = $this->forumReplyRepository->store($replyData);
            $forumPostId = $forumReply->forum_post_id;
            $forumReplyCount = $this->forumReplyRepository->getCountByForumPostId($forumPostId);
            $forumPost = $this->forumPostRepository->getById($forumPostId);

            $forumPostCreatedAt = $forumPost->created_at->toDateTimeString();
            $weight = $this->getForumPostRank($forumPostCreatedAt,$forumReplyCount);
  
            $postData = [];
            $postData['reply_count'] = $forumReplyCount;
            $postData['weight'] = $weight;
            $this->forumPostRepository->updateById($forumPostId,$postData);
            return $forumReply;

        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function destroyReply($replyId)
    {
        $validationData = [];
        $validationData['reply_id'] = $replyId;
        $rules = [
            'reply_id'    => 'required|verifyForumReplyId',
        ];
        Validator::extend('verifyForumReplyId', function($attribute, $value, $parameters, $validator) {
            return $this->verifyForumReplyId($value);
        });
        $validator = Validator::make($validationData, $rules);
        if($validator->passes()){
            $forumReply = $this->forumReplyRepository->getById($replyId);
            $this->forumReplyRepository->destroyById($replyId);

            $forumPostId = $forumReply->forum_post_id;
            $forumReplyCount = $this->forumReplyRepository->getCountByForumPostId($forumPostId);

            $postData = [];
            $postData['reply_count'] = $forumReplyCount;
            $this->forumPostRepository->updateById($forumPostId,$postData);
            return true;
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function getForumReplyPaginate(array $fileds=array(),$order='',$limit=20)
    {
        $getReplyData = [];
        $getReplyData['order'] = $order;
        $getReplyData += $fileds;
        $validator = $this->forumReplyRepository->getFilterValidator($getReplyData);
        $rules = $validator->getRules();
        $rules['order'][] = 'in:'.implode(',', $this->forumReplyRepository->getOrderFields());
        $validator->setRules($rules);
        if ($validator->passes()){
            $replyPaginate = $this->forumReplyRepository->paginate($fileds,[$order],$limit);
            return $replyPaginate;
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function getForumReplies(array $fileds=array(),$order='',$offset=0,$limit=20)
    {
        $getReplyData = [];
        $getReplyData['order'] = $order;
        $getReplyData += $fileds;
        $validator = $this->forumReplyRepository->getFilterValidator($getReplyData);
        $rules = $validator->getRules();
        $rules['order'][] = 'in:'.implode(',', $this->forumReplyRepository->getOrderFields());
        $validator->setRules($rules);
        if ($validator->passes()){
            $forumReplies = $this->forumReplyRepository->get($fileds,[$order],$offset,$limit);
            return $forumReplies;
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function getForumRepliesByForumPostId($forumPostId)
    {
        $fileds = [];
        $fileds['forum_post_id'] = $forumPostId;
        $forumReplies = $this->getForumReplies($fileds,'id_asc');
        return $forumReplies;
    }

    public function verifyForumPostPraiseByUserPassportIdForumPostId($userPassportId,$forumPostId)
    {
        $tag = $this->forumPostPraiseRepository->getByUserPassportIdForumPostId($userPassportId,$forumPostId);
        if($tag)
        {
            return false;
        }else{
            return true;
        }
    }

    public function storeForumPostPraise($praiseData)
    {
        $validator = $this->forumPostPraiseRepository->getStoreValidator($praiseData);
        $rules = $validator->getRules();
        $rules['forum_post_id'][]  = 'verifyForumPostId';
        $rules['user_passport_id'][]  = 'verifyForumPostPraiseByUserPassportIdForumPostId';        
        $validator->setRules($rules);       
        $validator->addExtension('verifyForumPostId', function($attribute, $value, $parameters, $validator) {
            return $this->verifyForumPostId($value);
        });

        $validator->addExtension('verifyForumPostPraiseByUserPassportIdForumPostId', function($attribute, $value, $parameters, $validator) use ( $praiseData ) {
            return $this->verifyForumPostPraiseByUserPassportIdForumPostId($praiseData['user_passport_id'],$praiseData['forum_post_id']);
        });

        if($validator->passes()){

            $forumPostPraise = $this->forumPostPraiseRepository->store($praiseData);
            $forumPostId = $forumPostPraise->forum_post_id;
            $forumPostPraiseCount = $this->forumPostPraiseRepository->getCountByForumPostId($forumPostId);
            $postData = [];
            $postData['praise_count'] = $forumPostPraiseCount;
            $this->forumPostRepository->updateById($forumPostId,$postData);
            return $forumPostPraise;

        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function destroyForumPostPraise($userPassportId,$forumPostId)
    {
        $validationData = [];
        $validationData['user_passport_id'] = $userPassportId;
        $validationData['forum_post_id'] = $forumPostId;
        $rules = [
            'user_passport_id'    => 'required|verifyForumPostPraiseByUserPassportIdForumPostId',
            'forum_post_id'    => 'required|verifyForumPostId', 
        ];
        Validator::extend('verifyForumPostPraiseByUserPassportIdForumPostId', function($attribute, $value, $parameters, $validator) use( $validationData ) {
            return !$this->verifyForumPostPraiseByUserPassportIdForumPostId($validationData['user_passport_id'],$validationData['forum_post_id']);
        });
        Validator::extend('verifyForumPostId', function($attribute, $value, $parameters, $validator) {
            return $this->verifyForumPostId($value);
        });

        $validator = Validator::make($validationData, $rules);
        if($validator->passes()){
            $forumPraise  = $this->forumPostPraiseRepository->getByUserPassportIdForumPostId($userPassportId,$forumPostId);
            $this->forumReplyRepository->destroyModel($forumPraise);

            $forumPostPraiseCount = $this->forumPostPraiseRepository->getCountByForumPostId($forumPostId);
            $postData = [];
            $postData['praise_count'] = $forumPostPraiseCount;
            $this->forumPostRepository->updateById($forumPostId,$postData);

            return true;
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function getForumPostPraises(array $fileds=array(),$order='',$offset=0,$limit=20)
    {
        $getReplyData = [];
        $getReplyData['order'] = $order;
        $getReplyData += $fileds;
        $validator = $this->forumPostPraiseRepository->getFilterValidator($getReplyData);
        $rules = $validator->getRules();
        $rules['order'][] = 'in:'.implode(',', $this->forumPostPraiseRepository->getOrderFields());
        $validator->setRules($rules);
        if ($validator->passes()){
            $forumPostPraises = $this->forumPostPraiseRepository->get($fileds,[$order],$offset,$limit);
            return $forumPostPraises;
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function getForumPostPraiseByForumPostId($forumPostId)
    {
        $fileds = [];
        $fileds['forum_post_id'] = $forumPostId;
        return $this->getForumPostPraises($fileds,'id_asc',0,0);

    }

}