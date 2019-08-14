@extends('layout.layouts')

@section('title', '添加试题')

@section('sidebar')
    @parent
@endsection

@section('content')
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <h2>请选择要添加试题的科目</h2>
    <select name="" id="subject" class="form-control select">
        <option value="">--请选择--</option>
        @foreach($subject as $k=>$v)
            <option value="{{$v->c_id}}">{{$v->c_name}}</option>
        @endforeach
    </select>

    <form class="form-inline" hidden>
        <p>
            <label for="exampleInputEmail1">请输入题目:</label><br>
            <input type="text" class="form-control" name="t_title">
        </p>
        <p>
            <label for="exampleInputName2">请输入选项答案:</label><br>
            A:<input type="text" class="form-control" name="a"><br>
            B:<input type="text" class="form-control" name="b"><br>
            C:<input type="text" class="form-control" name="c"><br>
            D:<input type="text" class="form-control" name="d">
        </p>
        <p>
            <label for="exampleInputEmail1">正确答案:</label><br>
            <input type="text" class="form-control" name="correct">
        </p>
        <input type="button" value="添加" class="btn btn-lg btn-primary" id="but">
    </form>
    <script>
        $(function(){
            //点击下拉 内容更新事件
            $('.select').change(function(){
                var c_id=$(this).val();
                //将表单展示出来
                $('.form-inline').show();
            })
            //点击添加
            $('#but').click(function(){
                var obj={};
                //科目id
                obj.c_id=$('#subject').val();
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
                $.post(
                    "/add_test",
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