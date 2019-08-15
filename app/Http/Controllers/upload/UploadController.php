<?php

namespace App\Http\Controllers\upload;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
        protected $config=[
            'savePath'=>'',//文件路径
            'size'=>-1,//限制文件上传大小
        ];
        public $error=0;
        public function __construct($config=[])
        {
            $this->config=array_merge($this->config,$config);
        }

        //课程图片上传
        public function uploadImg(Request $request){
            if ($request->hasFile('file') && $request->file('file')->isValid()) {
                $photo = $request->file('file');
                $extension = $photo->extension();
                $path = 'currimg/'.date('Y-m-d');
                if(!is_dir($path)){
                    mkdir($path,0777,true);
                }
                $store_result = $photo->store($path);
                $output = [
                    'status'=>1000,
                    'path' => $store_result
                ];
                return $output;
            }

            return ['status'=>108,'msg'=>'未获取到上传文件或上传过程出错'];

        }

        // 配置参数设置
        public function setConfig($key,$val){
            $this->config[$key]=$val;
        }

        public function upload($fileName,$size,$currentChunk,$chunks,$fileInfo){
            $fileName = $_POST['name']; //文件名
            $size = $_POST['size']; //文件总大小
            $currentChunk = $_POST['currentChunk'];//当前文件段数
            $chunks = $_POST['chunks']; //总段数
            if(!$this->fileSize($size)){
                $this->error=8;
                return;
            }
            $this->config['savePath']=storage_path().'/app/currVideo/'.DIRECTORY_SEPARATOR.md5($fileName);
            // 6 上传
            //判断上传目是否存在  不存在则创建
            if(!is_dir($this->config['savePath'])){
                mkdir($this->config['savePath'],0777,true);
            }

            $fileInfo=base64_decode($fileInfo);
            $res=file_put_contents($this->config['savePath'].DIRECTORY_SEPARATOR.$currentChunk.'.tmp',$fileInfo);
            $path=[];
            //取出里面文件
            if($fd=opendir($this->config['savePath'])){
                while(($file=readdir($fd))!==false){
                    if($file!=='.'&&$file!=='..'){
                        $path[]=$file;
                    }
                }
            }
            if(count($path)==$chunks){
                $sizeCount=0;
                foreach($path as $v){
                    $sizeCount = $sizeCount+filesize($this->config['savePath'].DIRECTORY_SEPARATOR.$v);
                }
                if($sizeCount!=$size){
                    $this->error=12;
                    return;
                }else{
                    $file_info='';
                    foreach ($path as $v){
                        $file_info .= file_get_contents($this->config['savePath'].DIRECTORY_SEPARATOR.$v);
                    }
                    $newname=$this->newFileName($fileName);
                    $path = storage_path().'/app/currVideo/'.date('Y-m-d');
                    if(!is_dir($path)){
                        mkdir($path,0777,true);
                    }
                    $res=file_put_contents($path.DIRECTORY_SEPARATOR.$newname,$file_info);
                    if($res!==0){
    //                        unlink($this->config['savePath']);
                        //上传成功
//                        if($fd=opendir($this->config['savePath'])){
//                            while(($file=readdir($fd))!==false){
//                                if($file!=='.'&&$file!=='..'){
//                                    $path[]=$file;
//                                }
//                            }
//                        }
//                        dd(Storage::deleteDirectory('app/curr'));
//                        dd(rmdir($this->config['savePath']));
//                        Storage::deleteDirectory($this->config['savePath']);
                        return ['name'=>$fileName,'size'=>$size,'path'=>'/app/upload/','fileName'=>$newname];
                    }
                }
            }else{
                if($res!==0){
                    return ['currentChunk'=>$currentChunk];
                }
            }

            // 7 返回路径名
    //        return ['name'=>filename,'size'=>$size,'path'=>$this->config['savePath'],'fileName'=>$fileName];

        }



        //文件错误码
        public function uploadError(){
            $error=$this->error;
            $errorStr='';
            switch ($error){
                case UPLOAD_ERR_INI_SIZE:
                    $errorStr='上传的文件大小超过了php配置的最大值';
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    $errorStr='上传文件的大小超过了HTML表单中MAX_FILE_SIZE的值';
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $errorStr='文件只有部分被上传';
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $errorStr='没有文件被上传';
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    $errorStr='找不到临时文件夹';
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    $errorStr='文件写入失败';
                    break;
                case 8:
                    $errorStr='文件大小超过配置';
                    break;
                case 9:
                    $errorStr='文件后缀名不符合规定';
                    break;
                case 10:
                    $errorStr='文件类型不合法';
                    break;
                case 11:
                    $errorStr='文件来源不合法';
                    break;
                case 12:
                    $errorStr='上传失败';
                    break;
            }
            return $errorStr;die;
        }
        //判断文件大小
        protected function fileSize($size){
            if($this->config['size']== -1){
                return true;
            }else{
                return $this->config['size']>=$size? true: false;
            }
        }


        //生成文件名
        protected function newFileName($name){
            $ext=$this->getFileExt($name);
            return uniqid().Str::random(5).'.'.$ext;
        }
        //获取文件后缀名
        protected function getFileExt($name){
            return pathinfo($name,PATHINFO_EXTENSION);
        }
}
