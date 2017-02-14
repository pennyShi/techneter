<?php 
namespace App\Services\Eloquent;

use App\Services\Contracts\OutputServiceInterface;

class OutputService implements OutputServiceInterface
{
    public function success($data = null)
    {
        $returnData = [];
        $returnData['status']  = 200;
        $returnData['message']['success'] = '成功';
        if($data)
        {
            $returnData['data'] = $data;
        }

        return response()->json($returnData);
    }

    public function fail($validationException = null)
    {
        $returnData = [];
        $returnData['status']  = 201;

        if($validationException)
        {
            $messages = $validationException->errors()->toArray();
            $returnData['message'] = $messages;
        }else{
            $returnData['message']['fail'] = '失败';
        }

        return response()->json($returnData);
    }

    public function exception()
    {
        $returnData = [];
        $returnData['status']  = 202;
        $returnData['message']['exception'] = '异常';
        return response()->json($returnData);
    }

    public function needLogin()
    {
        $returnData = [];
        $returnData['status']  = 203;
        $returnData['message']['exception'] = '需要登录';
        return response()->json($returnData);
    }
}