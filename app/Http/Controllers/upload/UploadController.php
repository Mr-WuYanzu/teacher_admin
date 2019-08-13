<?php

namespace App\Http\Controllers\upload;

use BaiduBce\Services\Bos\BosOptions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use BaiduBce\BceClientConfigOptions;
use BaiduBce\Util\Time;
use BaiduBce\Util\MimeTypes;
use BaiduBce\Http\HttpHeaders;
use BaiduBce\Services\Bos\BosClient;
use BaiduBce\Services\Bos\StorageClass;
use Illuminate\Support\Facades\Redis;

class UploadController extends Controller
{
    public $video_ext=[
        'mpg',
        'avi0',
        'mov',
        'swf',
    ];
    public function upload() {
        set_time_limit(0);
        $teacher_id=2;
        $file = $_FILES['file']??null;
        if(empty($file)){
            return ['status'=>107,'msg'=>'请选择文件上传'];
        }else if($file['error']==4){
            return ['status'=>107,'msg'=>'请选择文件上传'];
        }else if($file['error']==1){
            return ['status'=>107,'msg'=>'上传文件过大'];
        }
        include storage_path().'/bos/BaiduBce.phar';
        require storage_path().'/bos/YourConf.php';

//新建BosClient
        $client = new BosClient($BOS_TEST_CONFIG);
        $bucketName='class-hour-video';
        $objectName=$file['name'];

        $ext = $this->getFileExt($file['name']);
        $objectKey=uniqid().Str::random(5).'.'.$ext;
        $fileName=$file['tmp_name'];
        //利用options在通过文件上传Object的时候传入指定参数
        $user_meta = array("x-bce-meta-key1" => "value1");
        $response = $client->initiateMultipartUpload($bucketName, $objectKey);
        $uploadId =$response->uploadId;
        $options = array(
            BosOptions::STORAGE_CLASS => StorageClass::STANDARD_IA,
        );
        $client->initiateMultipartUpload($bucketName, $objectName, $options);

        //设置分块的开始偏移位置
        $offset = 0;
        $partNumber = 1;
        //设置每块为5MB
        $partSize = 5 * 1024 * 1024;
        $length = $partSize;
        $partList = array();
        $bytesLeft = $file['size'];
        //分块上传
        while ($bytesLeft > 0) {
            $length = ($length > $bytesLeft) ? $bytesLeft : $length;
            $response = $client->uploadPartFromFile($bucketName, $objectKey, $uploadId,  $partNumber, $fileName, $offset, $length);
            array_push($partList, array("partNumber"=>$partNumber, "eTag"=>$response->metadata["etag"]));
            $offset += $length;
            $partNumber++;
            $bytesLeft -= $length;
        }
        //完成分块上传
        $response = $client->completeMultipartUpload($bucketName, $objectKey, $uploadId, $partList);
        $file_name = $response->location;
        if(substr($file_name,0,4)=='http'){
            return ['status'=>1000,'msg'=>'ok','filename'=>$file_name];
        }else{
            return ['status'=>103,'msg'=>'错误'];
        }
    }

    public function CustomizedConfig() {
        $customizedConfig = array(
            BceClientConfigOptions::PROTOCOL => 'http',
            BceClientConfigOptions::REGION => 'gz',
            BceClientConfigOptions::CONNECTION_TIMEOUT_IN_MILLIS => 120 * 1000,
            BceClientConfigOptions::SOCKET_TIMEOUT_IN_MILLIS => 300 * 1000,
            BceClientConfigOptions::SEND_BUF_SIZE => 5 * 1024 * 1024,
            BceClientConfigOptions::RECV_BUF_SIZE => 5 * 1024 * 1024,
            BceClientConfigOptions::CREDENTIALS => array(
                'ak' => '794cc9307fad4ef0bd0d6a8fd1bcb234',
                'sk' => 'e64327f718954f6887e12761c4f8ef8f',
            ),
            'endpoint' => 'http://gz.bcebos.com',
        );
        //利用自定义配置创建BOSClient
        $customizedClient = new BosClient($customizedConfig);

        //通过自定义配置调用方法
        $options = array(BosOptions::CONFIG=>$customizedConfig);
        $this->client->listBuckets($options);
    }

        //获取文件后缀名
    protected function getFileExt($name){
        return pathinfo($name,PATHINFO_EXTENSION);
    }













//    protected $config=[
//        'savePath'=>'',//文件路径
//        'size'=>-1,//限制文件上传大小
//    ];
//    public $error=0;
//    public function __construct($config=[])
//    {
//        $this->config=array_merge($this->config,$config);
//    }
//    // 配置参数设置
//    public function setConfig($key,$val){
//        $this->config[$key]=$val;
//    }
//
//    public function upload($fileName,$size,$currentChunk,$chunks,$fileInfo){
//        $fileName = $_POST['name']; //文件名
//        $size = $_POST['size']; //文件总大小
//        $currentChunk = $_POST['currentChunk'];//当前文件段数
//        $chunks = $_POST['chunks']; //总段数
//        if(!$this->fileSize($size)){
//            $this->error=8;
//            return;
//        }
//        $this->config['savePath']=storage_path().'/upload'.DIRECTORY_SEPARATOR.md5($fileName);
//        // 6 上传
//        //判断上传目是否存在  不存在则创建
//        if(!is_dir($this->config['savePath'])){
//            mkdir($this->config['savePath'],0777,true);
//        }
//
//        $fileInfo=base64_decode($fileInfo);
//        $res=file_put_contents($this->config['savePath'].DIRECTORY_SEPARATOR.$currentChunk.'.tmp',$fileInfo);
//        $path=[];
//        //取出里面文件
//        if($fd=opendir($this->config['savePath'])){
//            while(($file=readdir($fd))!==false){
//                if($file!=='.'&&$file!=='..'){
//                    $path[]=$file;
//                }
//            }
//        }
//        if(count($path)==$chunks){
//            $sizeCount=0;
//            foreach($path as $v){
//                $sizeCount = $sizeCount+filesize($this->config['savePath'].DIRECTORY_SEPARATOR.$v);
//            }
//            if($sizeCount!=$size){
//                $this->error=12;
//                return;
//            }else{
//                $file_info='';
//                foreach ($path as $v){
//                    $file_info .= file_get_contents($this->config['savePath'].DIRECTORY_SEPARATOR.$v);
//                }
//                $newname=$this->newFileName($fileName);
//                $res=file_put_contents(storage_path().'/upload'.DIRECTORY_SEPARATOR.$newname,$file_info);
//                if($res!==0){
////                        unlink($this->config['savePath']);
//                    //上传成功
//                    return ['name'=>$fileName,'size'=>$size,'path'=>'/upload/','fileName'=>$newname];
//                }
//            }
//        }else{
//            if($res!==0){
//                return ['currentChunk'=>$currentChunk];
//            }
//        }
//
//        // 7 返回路径名
////        return ['name'=>filename,'size'=>$size,'path'=>$this->config['savePath'],'fileName'=>$fileName];
//
//    }
//
//
//
//    //文件错误码
//    public function uploadError(){
//        $error=$this->error;
//        $errorStr='';
//        switch ($error){
//            case UPLOAD_ERR_INI_SIZE:
//                $errorStr='上传的文件大小超过了php配置的最大值';
//                break;
//            case UPLOAD_ERR_FORM_SIZE:
//                $errorStr='上传文件的大小超过了HTML表单中MAX_FILE_SIZE的值';
//                break;
//            case UPLOAD_ERR_PARTIAL:
//                $errorStr='文件只有部分被上传';
//                break;
//            case UPLOAD_ERR_NO_FILE:
//                $errorStr='没有文件被上传';
//                break;
//            case UPLOAD_ERR_NO_TMP_DIR:
//                $errorStr='找不到临时文件夹';
//                break;
//            case UPLOAD_ERR_CANT_WRITE:
//                $errorStr='文件写入失败';
//                break;
//            case 8:
//                $errorStr='文件大小超过配置';
//                break;
//            case 9:
//                $errorStr='文件后缀名不符合规定';
//                break;
//            case 10:
//                $errorStr='文件类型不合法';
//                break;
//            case 11:
//                $errorStr='文件来源不合法';
//                break;
//            case 12:
//                $errorStr='上传失败';
//                break;
//        }
//        return $errorStr;die;
//    }
//    //判断文件大小
//    protected function fileSize($size){
//        if($this->config['size']== -1){
//            return true;
//        }else{
//            return $this->config['size']>=$size? true: false;
//        }
//    }
//
//
//    //生成文件名
//    protected function newFileName($name){
//        $ext=$this->getFileExt($name);
//        return uniqid().Str::random(5).'.'.$ext;
//    }
//

}
