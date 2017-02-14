<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Routing\Controller as BaseController;
use Request;
use Article;

class ArticleController extends BaseController
{
	public function index()
	{
		$articlePaginate = Article::getArticlePaginate();
		$articleCategories = Article::getArticleCategories([],'weight_desc',0,0);
		
		$data = [];
		$data['articlePaginate'] = $articlePaginate;
		$data['articleCategories'] = $articleCategories;
		return view('admin/article/index',$data);
	}

	public function create()
	{
		$articleCategories = Article::getArticleCategories([],'weight_desc',0,0);

		$data = array();
		$data['type'] = 'create';
		$data['articleCategories'] = $articleCategories;
		return view('admin/article/revise',$data);
	}

	public function store()
	{
		$storeData = [];
		$storeData['article_category_id'] = Request::input('article_category_id');
		$storeData['title']    			  = Request::input('title');
		$storeData['image']    			  = Request::input('image');
		$storeData['description']    	  = Request::input('description');
		$storeData['content']    		  = Request::input('content');
		$storeData['weight']    		  = Request::input('weight');
		$article = Article::storeArticle($storeData);
		return redirect('admin/article/article/'.$article->id.'/edit')->withInput()->with('reviseStatus',true);
	}

	public function edit($id)
	{
		$article = Article::getArticleById($id);
		$articleCategories = Article::getArticleCategories([],'weight_desc',0,0);

		$data = array();
		$data['type'] = 'update';
		$data['article'] = $article;
		$data['articleCategories'] = $articleCategories;
		return view('admin/article/revise',$data);
	}

	public function update($id)
	{
		$updateData = [];
		$updateData['article_category_id'] 	= Request::input('article_category_id');
		$updateData['title']    		   	= Request::input('title');
		$updateData['image']    			= Request::input('image');
		$updateData['description']    	  	= Request::input('description');
		$updateData['content']    		  	= Request::input('content');
		$updateData['weight']    		  	= Request::input('weight');
		$article = Article::updateArticle($id,$updateData);
		return redirect('admin/article/article/'.$article->id.'/edit')->withInput()->with('reviseStatus',true);
	}

}
