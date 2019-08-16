@extends('layout.layouts')

@section('title', '讲师资格申请')

@section('sidebar')
    @parent
@endsection

@section('content')
<table class="layui-table" lay-size="sm">
    <colgroup>
        <col width="150">
        <col width="200">
        <col>
    </colgroup>
    <thead>
    <tr>
        <th>课程名称</th>
        <th width="350">课程详情</th>
        <th>
            直播状态
        </th>
        <th >课程分类</th>
        <th >直播地址</th>
        <th >秘钥</th>
        <th>课程价格</th>
        <th>创建时间</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $k=>$v)
    <tr curr_id="{{$v['curr_id']}}">
        <td>{{$v['curr_name']}}</td>
        <td>{{str_replace(mb_substr($v['curr_detail'],20,mb_strlen($v['curr_detail'])),'...',$v['curr_detail'])}}</td>
        <td>
            @if($v['live_status']==2)
                正在直播
            @else
                还未开播
            @endif
        </td>
        <td>{{$v['cate_name']}}</td>
        <td class="live_url">{{$v['live_url']??null}}</td>
        <td class="key">{{$v['live_key']??null}}</td>
        <td>
            @if($v['is_pay']==1)
                免费
            @else
                {{$v['curr_price']}}
            @endif
        </td>
        <td>{{date('Y-m-d H:i',$v['create_time'])}}</td>
        <td>
            @if($v['live_status']==2)
                <button class="layui-btn layui-btn-radius layui-btn-warm" id="shutDown_live">点击下播</button>
            @else
                <button class="layui-btn layui-btn-radius layui-btn-warm" id="start_live">我要直播</button>
            @endif

        </td>
    </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(function () {
        $(document).on('click','#start_live',function () {
            //获取当前点击课程id
            var curr_id = $(this).parents('tr').attr('curr_id');
            var _live_url = $(this).parent('td').siblings('td[class=live_url]');
            var _key = $(this).parent('td').siblings('td[class=key]');
            $.ajax({
                url:'/start_live',
                type:'post',
                data:{curr_id:curr_id},
                dataType:'json',
                success:function (res) {
                    if(res.status==200){
                        _live_url.text(res.live_url);
                        _key.text(res.key);
                    }
                }
            })
        })
        $(document).on('click','#shutDown_live',function () {
            //获取当前点击课程id
            var curr_id = $(this).parents('tr').attr('curr_id');
            $.ajax({
                url:'/shutDown_live',
                type:'post',
                data:{curr_id:curr_id},
                dataType:'json',
                success:function (res) {
                    if(res.status==200){

                    }
                }
            })
        })
    })
</script>
@endsection