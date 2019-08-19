@extends('layout.layouts')

@section('title', '课程编辑')

@section('sidebar')
    @parent
@endsection

@section('content')

<form class="layui-form" method="post" action="" enctype="multipart/form-data"> <!-- 提示：如果你不想用form，你可以换成div等任何一个普通元素 -->
  <div class="layui-form-item">
    <label class="layui-form-label">课程名称</label>
    <div class="layui-input-inline">
        <input type="hidden" value="{{$currInfo['curr_id']}}" name="curr_id">
      <input type="text" name="curr_name" placeholder="请输入新的课程名称" autocomplete="off" class="layui-input" value="{{$currInfo['curr_name']}}">
    </div>
  </div>

    <div class="layui-form-item">
        <label class="layui-form-label">课程图片</label>
        <button type="button" class="layui-btn" id="test1">
            <i class="layui-icon">&#xe67c;</i>上传图片
            <input type="hidden" id="img_url" name="img_url" value="{{$currInfo['curr_img']}}">
        </button>
        <div id="divv" style="padding-left: 110px;">
            <img src="http://curr.img.com/{{$currInfo['curr_img']}}" alt="" width="80" height="130">
        </div>
    </div>
    
  <div class="layui-form-item">
    <label class="layui-form-label">是否付费</label>
    <div class="layui-input-block">
        @if($currInfo['is_pay']==2)
          <input type="radio" class="is_pay" lay-filter='is_pay' name="is_pay" value="2" title="是" checked>
          <input type="radio" class="is_pay" lay-filter='is_pay' name="is_pay" value="1" title="否" >
        @else
            <input type="radio" class="is_pay" lay-filter='is_pay' name="is_pay" value="2" title="是">
            <input type="radio" class="is_pay" lay-filter='is_pay' name="is_pay" value="1" title="否" checked>
        @endif
    </div>
  </div>

  <div class="layui-form-item" id="price_div" style="display:none;">
    <label class="layui-form-label">课程价格</label>
    <div class="layui-input-inline">
        @if($currInfo['is_pay']==2)
            <input type="text" name="curr_price" placeholder="请输入价格" autocomplete="off" class="layui-input" value="{{$currInfo['curr_price']}}">
        @else
            <input type="text" name="curr_price" placeholder="请输入价格" autocomplete="off" class="layui-input">
        @endif
    </div>
  </div>

  <div class="layui-form-item layui-form-text">
    <label class="layui-form-label">请填写描述</label>
    <div class="layui-input-block">
      <textarea placeholder="请输入内容" name="curr_detail" class="layui-textarea">{{$currInfo['curr_detail']}}</textarea>
    </div>
  </div>
  <div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn" lay-submit lay-filter="formDemo">修改信息</button>
      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
    </div>
  </div>
  <!-- 更多表单结构排版请移步文档左侧【页面元素-表单】一项阅览 -->
</form>

<script type="text/javascript">
    $(function(){
        layui.use(['layer','form','upload'],function(){
            var layer = layui.layer;
            var form = layui.form;
            var upload = layui.upload;
            var img_url = $('#img_url');
            var _divv = $('#divv');
            //执行实例  留着后期可能会涉及到修改课程图片
            var uploadInst = upload.render({
                elem: '#test1' //绑定元素
                ,url: '/uploadImg' //上传接口
                ,done: function(res){
                    if(res.status==1000){
                        img_url.val(res.path);
                        layer.msg('上传成功',{icon:1});
                        _divv.empty();
                        _divv.append('<img src=http://curr.img.com/'+res.path+' width="65" height="65">');
                    }else{
                        layer.msg(res.msg,{icon:5});
                    }
                }
                ,error: function(){
                    //请求异常回调
                }
            });

            form.on('radio(is_pay)',function(data){
                var val=data.value;
                if(val==2){
                    $('#price_div').prop('style','display:block');
                }else if(val==1){
                    $('#price_div').prop('style','display:none');
                }
            });

            //监听提交
            form.on('submit(formDemo)', function(data){
                $.ajax({
                    url:'/curr_update',
                    type:'post',
                    data:data.field,
                    dateType:'json',
                    success:function (res) {
                        if(res.status==200){
                            layer.msg(res.msg,{icon:1},function () {
                                location.href="/currList";
                            });
                        }else{
                            layer.msg(res.msg,{icon:5});
                        }
                    }
                })
                return false;
            });

        });
    });
</script>

@endsection