@extends('layout.layouts')

@section('title', '试题修改视图')

@section('sidebar')
    @parent
@endsection

@section('content')
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <div align="center">
        <form class="form-inline" action="/test_update" method="post">
            <input type="hidden" name="t_id" value="{{$editInfo->t_id}}">
            <p>
                <label for="exampleInputEmail1">请输入题目:</label><br>
                <input type="text" class="form-control" name="t_title" value="{{$editInfo->t_title}}">
                <label for="exampleInputEmail1" class="span"></label><br>
            </p>
            <p>
                <label for="exampleInputName2">请输入选项答案:</label><br>
                A:<input type="text" class="form-control" name="a" value="{{$editInfo->a}}"><br>
                B:<input type="text" class="form-control" name="b" value="{{$editInfo->b}}"><br>
                C:<input type="text" class="form-control" name="c" value="{{$editInfo->c}}"><br>
                D:<input type="text" class="form-control" name="d" value="{{$editInfo->d}}">
            </p>
            <p>
                <label for="exampleInputEmail1">正确答案:</label><br>
                <input type="text" class="form-control" name="correct" value="{{$editInfo->correct}}">
            </p>
            <input type="button" value="修改" class="btn btn-lg btn-primary">
        </form>
    </div>
    <script>
        $(function(){
            //点击修改
            $('.btn-primary').click(function () {
                var falg=false;
                var obj={};
                //科目id
                obj.t_id=$("[name=t_id]").val();
                //题目
                obj.t_title=$("[name=t_title]").val();
                //a选项
                obj.a=$("[name=a]").val();
                //a选项
                obj.b=$("[name=b]").val();
                //a选项
                obj.c=$("[name=c]").val();
                //a选项
                obj.d=$("[name=d]").val();
                //正确答案
                obj.correct=$("[name=correct]").val();
                //验证填写选项非空
                if(obj.c_id == ''){
                    alert('请选择一个科目');
                    return false;
                }
                if(obj.t_title == ''){
                    alert('请输入题目');
                    return false;
                }
                if(obj.a == ''){
                    alert('请输入a选项');
                    return false;
                }
                if(obj.b == ''){
                    alert('请输入b选项');
                    return false;
                }
                if(obj.c == ''){
                    alert('请输入c选项');
                    return false;
                }
                if(obj.d == ''){
                    alert('请输入d选项');
                    return false;
                }
                if(obj.correct == ''){
                    alert('请输入正确答案');
                    return false;
                }
                //题目唯一
                $.ajax({
                    method: "POST",
                    url: "/test_update_unique",
                    data: obj,
                    async:false
                }).done(function( msg ) {
                    // console.log(msg);
                    if(msg.code == 1){
                        alert(msg.msg);
                        falg = false;
                    }else{
                        falg = true;
                    }
                });
                if(falg == false){
                    return falg;
                }

                $.post(
                    "/test_update",
                    obj,
                    function(res){
                        // console.log(res);
                        if(res.code == 100){
                            alert(res.msg);
                            location.href='/list_test';
                        }else{
                            alert(res.msg);
                        }
                    }
                )
            })
        })
    </script>
@endsection