@extends('layout.index')
@section('title', '订单管理')

@section('content')
    <table class="layui-table">
        <colgroup>
            <col width="150">
            <col width="200">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th>用户名</th>
            <th>订单号</th>
            <th>课程</th>
            <th>总金额</th>
            <th>支付状态</th>
        </tr>
        </thead>

        <tbody>
        @foreach($orderInfo as $k=>$v)
        <tr>
            <td>{{$v['user_name']}}</td>
            <td>{{$v['order_no']}}</td>
            <td>{{$v['curr_name']}}</td>
            <td>{{$v['amount']}}</td>
            @if($v['pay_status'] ==1)
                <td>未支付</td>
            @elseif($v['pay_status'] ==2)
                <td>已支付</td>
            @elseif($v['pay_status'] ==3)
                <td>取消订单</td>
            @else
                <td>退款</td>
            @endif
        </tr>
        @endforeach
        </tbody>
    </table>




@endsection