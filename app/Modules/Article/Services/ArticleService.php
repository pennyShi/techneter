<?php 
namespace App\Modules\Article\Services;
use App\Modules\Article\Services\ArticleServiceInterface;
use App\Modules\Article\Repositories\Contracts\ArticleCategoryRepositoryInterface;
use App\Modules\Article\Repositories\Contracts\ArticleRepositoryInterface;
use App\Exceptions\ServiceException;
use Validator;
use Session;

class ArticleService implements ArticleServiceInterface{

    private $articleCategoryRepository;
    private $articleRepository;

    public function __construct(ArticleCategoryRepositoryInterface $articleCategoryRepository,
                                ArticleRepositoryInterface $articleRepository )
    {
        $this->articleCategoryRepository = $articleCategoryRepository;
        $this->articleRepository = $articleRepository;
    }

    public function verifyArticleCategoryId($id)
    {
        $rules = [
            'id' => 'required|integer|exists:article_categories,id,deleted_at,NULL',
        ];
        $validator = Validator::make(['id'=>$id], $rules);
        return $validator->passes();
    }

    public function storeArticleCategory(array $storeData)
    {
        $validator = $this->articleCategoryRepository->getStoreValidator($storeData);
        if ($validator->passes()){

            $articleCategory = $this->articleCategoryRepository->store($storeData);
            return $articleCategory;
        
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function updateArticleCategory($id,array $updateData)
    {
        $validatorData = [];
        $validatorData += $updateData;
        $validatorData['id'] = $id;    
        $validator = $this->articleCategoryRepository->getUpdateValidator($validatorData);
        $rules = $validator->getRules();
        $rules['id'][] = 'verifyArticleCategoryId';        
        $validator->setRules($rules);
        $validator->addExtension('verifyArticleCategoryId', function($attribute, $value, $parameters, $validator) {
            return $this->verifyArticleCategoryId($value);
        });
        if ($validator->passes()){

            $articleCategory = $this->articleCategoryRepository->updateById($id,$updateData);
            return $articleCategory;
        
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function destoryArticleCategory($id)
    {
        $validationData = [];
        $validationData['id'] = $id;
        $rules = [
            'id'    => 'required|verifyArticleCategoryId',
        ];
        Validator::extend('verifyArticleCategoryId', function($attribute, $value, $parameters, $validator) {
            return $this->verifyArticleCategoryId($value);
        });
        $validator = Validator::make($validationData, $rules);
        if($validator->passes()){
            return $this->articleCategoryRepository->destroyById($id);
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function getArticleCategories(array $fileds=array(),$order='weight_desc',$offset=0,$limit=20)
    { 
        $data = [];
        $data['order'] = $order;
        $data += $fileds;
        $validator = $this->articleCategoryRepository->getFilterValidator($data);
        $rules = $validator->getRules();
        $rules['order'][] = 'in:'.implode(',', $this->articleCategoryRepository->getOrderFields());
        $validator->setRules($rules);
        if ($validator->passes()){
            $articleCategories = $this->articleCategoryRepository->get($fileds,[$order],$offset,$limit);
            return $articleCategories;
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function getArticleCategoryPaginate(array $fileds=array(),$order='weight_desc',$limit=20)
    {
        $data = [];
        $data['order'] = $order;
        $data += $fileds;
        $validator = $this->articleCategoryRepository->getFilterValidator($data);
        $rules = $validator->getRules();
        $rules['order'][] = 'in:'.implode(',', $this->articleCategoryRepository->getOrderFields());
        $validator->setRules($rules);
        if ($validator->passes()){
            $articleCategoryPaginate = $this->articleCategoryRepository->paginate($fileds,[$order],$limit);
            return $articleCategoryPaginate;
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function getArticleCategoryById($id)
    {
        $validator = $this->articleCategoryRepository->getFilterValidator(['id'=>$id]);
        if($validator->passes()) {
            return $this->articleCategoryRepository->getById($id);
        }else{  
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function getArticleDefaultViewCount()
    {
        return $this->articleRepository->getDefaultViewCount();
    }

    public function storeArticle(array $storeData)
    {
        if(!isset($storeData['view_count']))
        {
            $storeData['view_count'] = $this->getArticleDefaultViewCount();
        }

        $validator = $this->articleRepository->getStoreValidator($storeData);
        if ($validator->passes()){
            $article = $this->articleRepository->store($storeData);
            return $article;
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function updateArticle($id,array $updateData)
    {
        $validatorData = [];
        $validatorData += $updateData;
        $validatorData['id'] = $id;    
        $validator = $this->articleRepository->getUpdateValidator($validatorData);
        $rules = $validator->getRules();
        $rules['id'][] = 'verifyArticleId';        
        $validator->setRules($rules);
        $validator->addExtension('verifyArticleId', function($attribute, $value, $parameters, $validator) {
            return $this->verifyArticleId($value);
        });
        if ($validator->passes()){

            $article = $this->articleRepository->updateById($id,$updateData);
            return $article;
        
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function destoryArticle($id)
    {
        $validationData = [];
        $validationData['id'] = $id;
        $rules = [
            'id'    => 'required|verifyArticleId',
        ];
        Validator::extend('verifyArticleId', function($attribute, $value, $parameters, $validator) {
            return $this->verifyArticleId($value);
        });
        $validator = Validator::make($validationData, $rules);
        if($validator->passes()){
            return $this->articleRepository->destroyById($id);
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function getArticles(array $fileds=array(),$order='weight_desc',$offset=0,$limit=20)
    { 
        $data = [];
        $data['order'] = $order;
        $data += $fileds;
        $validator = $this->articleRepository->getFilterValidator($data);
        $rules = $validator->getRules();
        $rules['order'][] = 'in:'.implode(',', $this->articleRepository->getOrderFields());
        $validator->setRules($rules);
        if ($validator->passes()){
            $articles = $this->articleRepository->get($fileds,[$order],$offset,$limit);
            return $articles;
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function getArticleByArticleCategoryId($articleCategoryId,$order='weight_desc',$offset=0,$limit=20)
    {
        $fileds = [];
        $fileds['article_category_id'] = $articleCategoryId;
        return $this->getArticles($fileds,$order,$offset,$limit);
    }

    public function getArticlePaginate(array $fileds=array(),$order='',$limit=20)
    {
        $data = [];
        $data['order'] = $order;
        $data += $fileds;
        $validator = $this->articleRepository->getFilterValidator($data);
        $rules = $validator->getRules();
        $rules['order'][] = 'in:'.implode(',', $this->articleRepository->getOrderFields());
        $validator->setRules($rules);
        if ($validator->passes()){
            $articlePaginate = $this->articleRepository->paginate($fileds,[$order],$limit);
            return $articlePaginate;
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function getArticleById($id)
    {
        $validator = $this->articleRepository->getFilterValidator(['id'=>$id]);
        if($validator->passes()) {
            return $this->articleRepository->getById($id);
        }else{  
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function verifyArticleId($id)
    {
        $rules = [
            'id'    => 'required|integer|exists:articles,id,deleted_at,NULL',
        ];
        $validator = Validator::make(['id'=>$id], $rules);
        return $validator->passes();
    }

    public function verifyArticleIds(array $ids)
    {
        $rules = [
            'ids'    => 'required|array',
            'ids.*'  => 'required|integer|exists:articles,id,deleted_at,NULL',            
        ];
        $validator = Validator::make(['ids'=>$ids], $rules);
        return $validator->passes();
    }

    public function incrByArticleViewCount($articleId,$count=1)
    {
        $validatorData = ['id' => $articleId,'count' => $count];
        $rules = [
            'id' => 'required|verifyArticleId',
            'count' => 'required|integer|min:1',
        ];
        Validator::extend('verifyArticleId', function($attribute, $value, $parameters, $validator) {
            return $this->verifyArticleId($value);
        });
        $validator = Validator::make($validatorData, $rules);
        if ($validator->passes()){
            return $this->articleRepository->incrByViewCount($articleId,$count);
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function decrByArticleViewCount($articleId,$count=1)
    {
        $validatorData = ['id' => $articleId,'count' => $count];
        $rules = [
            'id' => 'required|verifyArticleId',
            'count' => 'required|integer|min:1',
        ];
        Validator::extend('verifyArticleId', function($attribute, $value, $parameters, $validator) {
            return $this->verifyArticleId($value);
        });
        $validator = Validator::make($validatorData, $rules);
        if ($validator->passes()){
            return $this->articleRepository->decrByViewCount($articleId,$count);
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

}