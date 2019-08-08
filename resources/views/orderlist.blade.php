


@extends('layouts')

@section('title', 'Laravel学院')

@section('sidebar')
    @parent
@endsection

@section('content')
    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div style="padding: 15px;">
            <table border="1">
                <tr>
                    <td>订单号</td>
                    <td>子订单号</td>
                    <td>商品总金额</td>
                </tr>
                @foreach($shop_order as $k=>$v)
                <tr>
                    <td>{{$v->order_no}}</td>
                    <td>{{$v->order_son_no}}</td>
                    <td>{{$v->count_price}}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection

