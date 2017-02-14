<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Routing\Controller as BaseController;
use Request;
use Article;

class ArticleCategoryController extends BaseController
{
	public function index()
	{
		$articleCategoryPaginate = Article::getArticleCategoryPaginate();
		$data = [];
		$data['articleCategoryPaginate'] = $articleCategoryPaginate;
		return view('admin/articleCategory/index',$data);
	}

	public function create()
	{
		$data = array();
		$data['type'] = 'create';
		return view('admin/articleCategory/revise',$data);
	}

	public function store()
	{
		$storeData = [];
		$storeData['name']    = Request::input('name');
		$storeData['weight']  = Request::input('weight');
		$articleCategory = Article::storeArticleCategory($storeData);
		return redirect('admin/article/category/'.$articleCategory->id.'/edit')->withInput()->with('reviseStatus',true);
	}

	public function edit($id)
	{
		$articleCategory = Article::getArticleCategoryById($id);
		$data = array();
		$data['type'] = 'update';
		$data['articleCategory'] = $articleCategory;
		return view('admin/articleCategory/revise',$data);
	}

	public function update($id)
	{
		$updateData = [];
		$updateData['name']    = Request::input('name');
		$updateData['weight']  = Request::input('weight');
		$articleCategory = Article::updateArticleCategory($id,$updateData);
		return redirect('admin/article/category/'.$articleCategory->id.'/edit')->withInput()->with('reviseStatus',true);
	}

}
