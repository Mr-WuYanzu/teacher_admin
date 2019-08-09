@extends('layout.layouts')

@section('title', '讲师资格申请')

@section('sidebar')
    @parent
@endsection

@section('content')
        <p>
        <form class="layui-form" action="">
            <div class="layui-form-item">
                <label class="layui-form-label">课程名称</label>
                <div class="layui-input-block">
                    <input type="text" name="teacher_name" required  lay-verify="required" placeholder="请输入课程名称" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">课程分类</label>
                <div class="layui-input-block">
                    <select name="city" lay-verify="required">
                        <option value=""></option>
                        <option value="0">北京</option>
                        <option value="1">上海</option>
                        <option value="2">广州</option>
                        <option value="3">深圳</option>
                        <option value="4">杭州</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">是否付费</label>
                <div class="layui-input-block">
                    <input type="radio" name="sex" value="2" title="是">
                    <input type="radio" name="sex" value="1" title="否" checked>
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">课程介绍</label>
                <div class="layui-input-block">
                    <textarea name="teacher_desc" placeholder="介绍一下此课程吧" class="layui-textarea"></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="formDemo">提交</button>
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

@endsection