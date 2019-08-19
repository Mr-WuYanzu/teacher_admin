@extends('layout.layouts')

@section('title', '课程列表')

@section('sidebar')
    @parent
@endsection

@section('content')
<table class="layui-table">
    <colgroup>
        <col width="150">
        <col width="200">
        <col>
    </colgroup>
    <thead>
    <tr>
        <th>课程名称</th>
        <th>课程状态</th>
        <th width="350">课程详情</th>
        <th >课程分类</th>
        <th>课程价格</th>
        <th>创建时间</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $k=>$v)
    <tr curr_id="{{$v['curr_id']}}">
        <td>{{$v['curr_name']}}</td>
        <td class="status">
            @if($v['status']==2)
                更新中
            @else
                完结
            @endif
        </td>
        <td>{{str_replace(mb_substr($v['curr_detail'],20,mb_strlen($v['curr_detail'])),'...',$v['curr_detail'])}}</td>
        <td>{{$v['cate_name']}}</td>
        <td>
            @if($v['is_pay']==1)
                免费
            @else
                {{$v['curr_price']}}
            @endif
        </td>
        <td>{{date('Y-m-d H:i',$v['create_time'])}}</td>
        <td>
            @if($v['status']==2)
                <button class="layui-btn layui-btn-xs end">完结此课程</button>
            @endif
            @if($v['is_show']==2)
                <button  class="layui-btn layui-btn-xs up">上架</button>
            @endif
                <button  class="layui-btn layui-btn-xs down">下架</button>
                <button  class="layui-btn layui-btn-xs del">删除</button>
                <a href="/curr_edit/{{$v['curr_id']}}"><button  class="layui-btn layui-btn-xs upd">修改</button></a>
        </td>
    </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(function () {
        layui.use(['form','layer'], function(){
            var form = layui.form;
            var layer = layui.layer;
            //监听提交
            form.on('submit(formDemo)', function(data){
                layer.msg(JSON.stringify(data.field));
                return false;
            });
        //点击完结
        $(document).on('click','.end',function () {
            var curr_id = $(this).parents('tr').attr('curr_id');
            var _this = $(this);
            var _status = _this.parents('tr').find('td[class=status]');
            $.ajax({
                url:'/currEnd',
                type:'post',
                data:{curr_id:curr_id},
                dataType:'json',
                success:function (res) {
                    if(res.status==200){
                        layer.msg(res.msg,{icon:1});
                        //将完结按钮去掉
                        _this.remove();
                        //将课程状态设为完结
                        _status.text('完结');
                    }else{
                        layer.msg(res.msg,{icon:5});
                    }
                }
            })
        })
        //点击上架
        $(document).on('click','.up',function () {
            var curr_id = $(this).parents('tr').attr('curr_id');
            var _this = $(this);
            $.ajax({
                url:'/currUp',
                type:'post',
                data:{curr_id:curr_id},
                dataType:'json',
                success:function (res) {
                    if(res.status==200){
                        layer.msg(res.msg,{icon:1});
                        //将按钮变成下架改变class
                        _this.text('下架');
                        _this.prop('class','layui-btn layui-btn-xs down');
                    }else{
                        layer.msg(res.msg,{icon:5});
                    }
                }
            })
        })
        //点击下架
        $(document).on('click','.down',function () {
            var curr_id = $(this).parents('tr').attr('curr_id');
            var _this = $(this);
            $.ajax({
                url:'/currDown',
                type:'post',
                data:{curr_id:curr_id},
                dataType:'json',
                success:function (res) {
                    if(res.status==200){
                        layer.msg(res.msg,{icon:1});
                        //将按钮变成上架，改变class
                        _this.text('上架');
                        _this.prop('class','layui-btn layui-btn-xs up');
                    }else{
                        layer.msg(res.msg,{icon:5});
                    }
                }
            })
        })
        //点击删除
        $(document).on('click','.del',function () {
            var curr_id = $(this).parents('tr').attr('curr_id');
            var _this = $(this);
            var _status = _this.parents('tr').find('td[class=status]');
            $.ajax({
                url:'/currDel',
                type:'post',
                data:{curr_id:curr_id},
                dataType:'json',
                success:function (res) {
                    if(res.status==200){
                        layer.msg(res.msg,{icon:1});
                        // 将这条数据行删掉
                        _this.parents('tr').remove();
                    }else{
                        layer.msg(res.msg,{icon:5});
                    }
                }
            })
        })
    })
    });
</script>
@endsection