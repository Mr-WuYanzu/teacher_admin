<?php

namespace App\Http\Controllers;

use App\Token;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload(Request $request){
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $photo = $request->file('file');
            $extension = $photo->extension();
            $path = 'goods/goods'.date('Y-m-d');
            if(!is_dir($path)){
                mkdir($path,0777,true);
            }
            $store_result = $photo->store($path);
            $output = [
                'status'=>1000,
                'path' => $store_result
            ];
            return $output;
            exit();
        }
        return ['status'=>104,'msg'=>'未获取到上传文件或上传过程出错'];
    }

}
