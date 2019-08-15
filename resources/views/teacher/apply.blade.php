@extends('layout.layouts')

@section('title', '讲师资格申请')

@section('sidebar')
    @parent
@endsection

@section('content')
    @if($type==2)
        <h1>您已经提交审核，请耐心等待审核</h1>
        @elseif($type==3)
        <h1>您已经是讲师了，请不要重复申请</h1>
        @else
        <p>
        <form class="layui-form" action="">
            <div class="layui-form-item">
                <label class="layui-form-label">讲师昵称</label>
                <div class="layui-input-block">
                    <input type="text" name="teacher_name" required  lay-verify="required" placeholder="请取个名字吧" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">上传您的头像</label>
                <button type="button" class="layui-btn" id="test1">
                    <i class="layui-icon">&#xe67c;</i>上传图片
                    <input type="hidden" id="img_url" name="header_img">
                </button>
                <div id="divv" style="padding-left: 110px;"></div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">教学方向</label>
                <div class="layui-input-block">
                    <input type="text" name="teacher_direction" required  lay-verify="required" placeholder="请说明您的教学方向" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">自我介绍</label>
                <div class="layui-input-block">
                    <textarea name="teacher_desc" placeholder="请介绍一下你自己吧" class="layui-textarea"></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="formDemo">提交申请</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        </form>

        <script>
            //Demo
            layui.use(['form','upload','layer'], function(){
                var form = layui.form;
                var layer = layui.layer;
                var upload=layui.upload;
                var img_url = $('#img_url');
                var _divv = $('#divv');
                //执行实例
                var uploadInst = upload.render({
                    elem: '#test1' //绑定元素
                    ,url: '/header_img' //上传接口
                    ,done: function(res){
                        //上传完毕回调
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

                //监听提交
                form.on('submit(formDemo)', function(data){
                    $.ajax({
                        url:'/applyDo',
                        type:'post',
                        data:data.field,
                        dataType:'json',
                        success:function (res) {
                            if(res.status==200){
                                layer.msg(res.msg,{icon:1},function () {
                                    history.go(0);
                                });
                            }else{
                                layer.msg(res.msg,{icon:5});
                            }
                        }
                    })
                    return false;
                });
            });
        </script>

        </p>
        @endif

@endsection