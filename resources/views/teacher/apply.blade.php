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
            layui.use('form', function(){
                var form = layui.form;

                //监听提交
                form.on('submit(formDemo)', function(data){
                    $.ajax({
                        url:'/applyDo',
                        type:'post',
                        data:data.field,
                        dataType:'json',
                        success:function (res) {
                            alert(res.msg);
                        }
                    })
                    return false;
                });
            });
        </script>

        </p>
        @endif

@endsection