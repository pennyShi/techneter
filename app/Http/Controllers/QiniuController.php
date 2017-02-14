<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Qiniu\Auth;

class QiniuController extends BaseController
{
	private $bucket;
	private $accessKey;
	private $secretKey;

	public function __construct()
	{
		$this->bucket = config('qiniu.bucket');
		$this->accessKey = config('qiniu.accessKey');
		$this->secretKey = config('qiniu.secretKey');		
	}

	public function upToken()
	{
	  $auth = new Auth($this->accessKey, $this->secretKey);
	  $upToken = $auth->uploadToken($this->bucket);

	  $returnData = [];
	  $returnData['uptoken'] = $upToken;
	  return response()->json($returnData);
	}



}
