@extends('layout.layouts')

@section('title', '讲师资格申请')

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
        <td>{{$v['curr_detail']}}</td>
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
                <button class="end">完结此课程</button>
            @endif
            @if($v['is_show']==2)
                <button class="up">上架</button>
            @endif
                <button class="down">下架</button>
                <button class="del">删除</button>
                <button class="upd">修改</button>
        </td>
    </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(function () {
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
                    alert(res.msg);
                    if(res.status==200){
                        //将完结按钮去掉
                        _this.remove();
                        //将课程状态设为完结
                        _status.text('完结');
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
                    alert(res.msg);
                    if(res.status==200){
                        //将按钮变成下架改变class
                        _this.text('下架');
                        _this.prop('class','down');
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
                    alert(res.msg);
                    if(res.status==200){
                        //将按钮变成上架，改变class
                        _this.text('上架');
                        _this.prop('class','up');
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
                    alert(res.msg);
                    if(res.status==200){
                        // 将这条数据行删掉
                        _this.parents('tr').remove();
                    }
                }
            })
        })
    })
</script>
@endsection