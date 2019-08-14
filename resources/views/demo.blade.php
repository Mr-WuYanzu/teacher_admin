<?php
//检测是否有课程图片
        if($request->hasFile('curr_img')){
            $data['curr_img']=$this->uploadImg($request->curr_img);
            if($data['curr_img']==2){
                $this->abort('上传课程图片失败','/curr');return;
            }
        }else{
            $this->abort('请上传课程图片','/curr');return;
        }
        //添加入库
        $result = Curr::insert($data);
        if($result){
            // return ['status'=>200,'msg'=>'添加成功'];
            $this->abort('添加成功','/currList');
        }else{
            // return ['status'=>106,'msg'=>'添加失败'];
            $this->abort('添加成功','/curr');
        }

    }

    /**
     * [上传课程图片]
     * @param  [type] $curr_img [description]
     * @return [type]           [description]
     */
    public function uploadImg($curr_img)
    {
        //检测文件上传过程中是否出错
        if($curr_img->isValid()){
            //获取文件路径
            $path=$curr_img->path();
            //获取文件扩展名
            $extension=$curr_img->getClientOriginalExtension();
            //拼接文件随机名称
            $fileName=md5(time().rand(1000,9999)).'.'.$extension;
            //拼接存放文件夹名称
            $dirName='curr/'.date('Ymd');
            //上传临时文件
            $result=$curr_img->storeAs($dirName,$fileName);
            //上传成功返回路径,失败返回提示
            if(!empty($result)){
                return $result;
            }else{
                return 2;
            }
        }
    }

?>

@extends('layout.layouts')

@section('title', '课程添加')

@section('sidebar')
    @parent
@endsection

@section('content')

<form class="layui-form" method="post" action="/currAdd" enctype="multipart/form-data"> <!-- 提示：如果你不想用form，你可以换成div等任何一个普通元素 -->
  <div class="layui-form-item">
    <label class="layui-form-label">课程名称</label>
    <div class="layui-input-inline">
      <input type="text" name="curr_name" placeholder="请输入课程名称" autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">课程分类</label>
    <div class="layui-input-inline">
      <select name="curr_cate_id" lay-filter="aihao">
        <option value="">请选择分类</option>
        @foreach($cateInfo as $v)
        <option value="{{$v['curr_cate_id']}}"><?php echo str_repeat('&nbsp;',$v['level']*6);?>{{$v['cate_name']}}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">课程图片</label>
    <div class="layui-input-inline">
      <input type="file" name="curr_img" autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">是否付费</label>
    <div class="layui-input-block">
      <input type="radio" class="is_pay" lay-filter='is_pay' name="is_pay" value="2" title="是">
      <input type="radio" class="is_pay" lay-filter='is_pay' name="is_pay" value="1" title="否" checked>
    </div>
  </div>
  <div class="layui-form-item" id="price_div" style="display:none;">
    <label class="layui-form-label">课程价格</label>
    <div class="layui-input-inline">
      <input type="text" name="curr_price" placeholder="请输入价格" autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item layui-form-text">
    <label class="layui-form-label">请填写描述</label>
    <div class="layui-input-block">
      <textarea placeholder="请输入内容" name="curr_detail" class="layui-textarea"></textarea>
    </div>
  </div>
  <div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn" lay-submit lay-filter="*">立即提交</button>
      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
    </div>
  </div>
  <!-- 更多表单结构排版请移步文档左侧【页面元素-表单】一项阅览 -->
</form>

<script type="text/javascript">
    $(function(){
        layui.use(['layer','form'],function(){
            var layer = layui.layer;
            var form = layui.form;

            form.on('radio(is_pay)',function(data){
                var val=data.value;
                if(val==2){
                    $('#price_div').prop('style','display:block');
                }else if(val==1){
                    $('#price_div').prop('style','display:none');
                }
            });

        });
    });
</script>

@endsection