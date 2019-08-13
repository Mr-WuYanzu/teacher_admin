@extends('layout.layouts')

@section('title', '试题列表视图')

@section('sidebar')
    @parent
@endsection

@section('content')
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <div align="center">
        <h2>科目：</h2>
        @foreach($subject as $k=>$v)
            <input type="button" value="{{$v->c_name}}" class="btn btn-lg btn-primary" id="but" c_id="{{$v->c_id}}">
        @endforeach
        <br><br><br>
    </div>
    <p class="p">

    </p>


<script>
    $(function(){
           $(document).on('click','#but',function(){
               //获取当前的科目id
               var c_id=$(this).attr('c_id');
               $.post(
                   "/subject_test_list",
                   {c_id:c_id},
                   function(res){
                       // console.log(res);
                       if(res){
                           $('.p').html(res);
                       }
                   }
               )
           })
    })
</script>

@endsection