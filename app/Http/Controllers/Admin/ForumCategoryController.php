<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Routing\Controller as BaseController;
use Request;
use Forum;

class ForumCategoryController extends BaseController
{
	public function index()
	{
		$forumCategoryPaginate = Forum::getForumCategoryPaginate();
		$data = [];
		$data['forumCategoryPaginate'] = $forumCategoryPaginate;
		return view('admin/forumCategory/index',$data);
	}

	public function create()
	{
		$data = array();
		$data['type'] = 'create';
		return view('admin/forumCategory/revise',$data);
	}

	public function store()
	{
		$storeData = [];
		$storeData['name']    = Request::input('name');
		$storeData['weight']  = Request::input('weight');
		$forumCategory = Forum::storeForumCategory($storeData);
		return redirect('admin/forum/category/'.$forumCategory->id.'/edit')->withInput()->with('reviseStatus',true);
	}

	public function edit($id)
	{
		$forumCategory = Forum::getForumCategoryById($id);
		$data = array();
		$data['type'] = 'update';
		$data['forumCategory'] = $forumCategory;
		return view('admin/forumCategory/revise',$data);
	}

	public function update($id)
	{
		$updateData = [];
		$updateData['name']    = Request::input('name');
		$updateData['weight']  = Request::input('weight');
		$forumCategory = Forum::updateForumCategory($id,$updateData);
		return redirect('admin/forum/category/'.$forumCategory->id.'/edit')->withInput()->with('reviseStatus',true);
	}

}
