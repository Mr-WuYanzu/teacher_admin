@extends('layout.layouts')

@section('title', '课程章节添加')

@section('sidebar')
    @parent
@endsection

@section('content')
        <p>
        <form class="layui-form" action="">
            <div class="layui-form-item">
                <label class="layui-form-label">选择课程</label>
                <div class="layui-input-block">
                    <select name="curr_id" lay-verify="required" lay-filter="curr">
                        <option value=""></option>
                        @foreach($currInfo as $k=>$v)
                        <option value="{{$v['curr_id']}}">{{$v['curr_name']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">当前添加的章节</label>
                <div class="layui-input-block">
                    <span id="chapter"></span>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">章节名称</label>
                <div class="layui-input-block">
                    <input type="text" name="chapter_name" required  lay-verify="required" placeholder="请输入章节名称" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">章节介绍</label>
                <div class="layui-input-block">
                    <textarea name="chapter_desc" placeholder="介绍一下此课程吧" class="layui-textarea"></textarea>
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
                form.on('select(curr)', function(data){
                    var curr_id = data.value;
                    var _chapter=$('#chapter');
                    //获取当前课程的章节
                    $.ajax({
                        url:'/chapterNum',
                        type:'post',
                        data:{curr_id:curr_id},
                        async:false,
                        dataType:'json',
                        success:function (res) {
                            if(res.status==200){
                                _chapter.empty();
                                _chapter.text('第'+res.chapterNum+'章');
                            }else{
                                _chapter.empty();
                                alert(res.msg);
                            }
                        }
                    })
                });
                //监听提交 章节添加
                form.on('submit(formDemo)', function(data){
                    $.ajax({
                        url:'/chapterAdd',
                        type:'post',
                        data:data.field,
                        dataType:'json',
                        success:function (res) {
                            alert(res.msg);
                            if(res.status==200){
                                history.go(0);
                            }
                        }
                    })
                    return false;
                });
            });
        </script>

        </p>

@endsection