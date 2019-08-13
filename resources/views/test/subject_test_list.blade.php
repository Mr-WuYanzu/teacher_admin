<!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<table class="table table-bordered">
    <tr>
        <td>题目</td>
        <td>A:</td>
        <td>B:</td>
        <td>C:</td>
        <td>D:</td>
        <td>正确答案</td>
        <td>管理</td>
    </tr>
    <h2 align="center" style="color:#5548FF;">{{$c_name}}试题</h2>
    @foreach($Info as $k=>$v)
        <tr>
            <td>{{$v->t_title}}</td>
            <td>{{$v->a}}</td>
            <td>{{$v->b}}</td>
            <td>{{$v->c}}</td>
            <td>{{$v->d}}</td>
            <td>{{$v->correct}}</td>
            <td>
                <button type="button" class="btn btn-danger" t_id="{{$v->t_id}}">删除</button>
                <a href="/test_edit/{{$v->t_id}}"><button type="button" class="btn btn-primary btn-lg disabled">修改</button></a>
            </td>
        </tr>
    @endforeach
</table>
<script>
    $(function(){
        //删除
        $(document).on('click','.btn-danger',function(){
            //获取题目的id
            var t_id=$(this).attr('t_id');
            $.post(
                "/test_del",
                {t_id:t_id},
                function(res){
                    // console.log(res);
                    if(res.code == 100){
                        alert(res.msg);
                    }else{
                        alert(res.msg);
                    }
                }
            )
        })
    })
</script>