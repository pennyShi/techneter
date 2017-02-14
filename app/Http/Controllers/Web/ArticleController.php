<?php

namespace App\Http\Controllers\Web;
use Illuminate\Routing\Controller as BaseController;
use Article;
use Output;
use Request;

class ArticleController extends BaseController
{
	public function index()
	{
		$articleCategories = Article::getArticleCategories([],'weight_desc',0,0);
		$categoryArticles = [];
		foreach($articleCategories AS $articleCategory)
		{
			$articles = Article::getArticleByArticleCategoryId($articleCategory->id,'weight_desc',0,3);
			$categoryArticles[$articleCategory->id] = $articles;
 		}

 		$data = [];
 		$data['articleCategories'] = $articleCategories;
 		$data['categoryArticles'] = $categoryArticles;
		return view('web/article/index',$data);
	}

	public function category($articleCategoryId)
	{
		$articleCategory = Article::getArticleCategoryById($articleCategoryId);
		$fileds = [];
		$fileds['article_category_id'] = $articleCategoryId;
		$articlePaginate = Article::getArticlePaginate($fileds,'weight_desc');

		$data = [];
		$data['articlePaginate'] = $articlePaginate;
		$data['articleCategory'] = $articleCategory;
		$data['title'] = 'Techneter-'.$articleCategory->name.'资讯频道';
		$data['keywords'] = $articleCategory->name.'资讯频道';
		$data['description'] = $articleCategory->name.'资讯频道';
		return view('web/article/category',$data);
	}

	public function show($articleId)
	{
		$article = Article::incrByArticleViewCount($articleId);
		$fileds = [];
		$fileds['article_category_id'] = $article->article_category_id;
		$recommendArticles = Article::getArticles($fileds,'rand',0,3);
	
		$data = [];
		$data['article'] = $article;
		$data['recommendArticles'] = $recommendArticles;
		$data['title'] = 'Techneter-'.$article->title;
		$data['keywords'] = $article->title;
		$data['description'] = $article->description;
		return view('web/article/show',$data);
	}

}
