<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Routing\Controller as BaseController;
use Ad;
use Request;
use Output;

class AdController extends BaseController
{
	public function index()
	{
		$locations = Ad::getAdLocations();
		$transLocations = Ad::getAdTransLocations();
		$ads = Ad::getAds([],'weight_desc',0,0);

		$data = [];
		$data['transLocations'] = $transLocations;
		$data['locations'] 		= $locations;
		$data['ads']			= $ads;
		return view('admin/ad/index',$data);
	}

	public function getById()
	{
		$id = Request::input('id');
		$ad = Ad::getAdById($id);
		$data = [];
		$data['ad'] = $ad->toArray();
		return Output::success($data);
	}

	public function store()
	{
		$storeData = [];
		$storeData['location'] 	  = Request::input('location');
		$storeData['title'] 	  = Request::input('title');
		$storeData['description'] = Request::input('description');
		$storeData['image'] 	  = Request::input('image');
		$storeData['url'] 		  = Request::input('url');
		$storeData['weight'] 	  = Request::input('weight');
		$ad = Ad::storeAd($storeData);

		$data = [];
		$data['ad'] = $ad->toArray();
		return Output::success($data);
	}

	public function update($id)
	{
		$updateData['location'] 	= Request::input('location');
		$updateData['title'] 		= Request::input('title');
		$updateData['description'] 	= Request::input('description');
		$updateData['image'] 		= Request::input('image');
		$updateData['url'] 			= Request::input('url');
		$updateData['weight'] 		= Request::input('weight');

		$ad = Ad::updateAd($id,$updateData);
		$data = [];
		$data['ad'] = $ad->toArray();
		return Output::success($data);
	}

	public function destroy($id)
	{
		Ad::destroyAd($id);
		return Output::success();
	}

}
