
@extends('layouts')

@section('title', 'Laravel学院')

@section('sidebar')
    @parent
@endsection

@section('content')

    <div style="padding: 15px">

        <input type="hidden" id="goods_id" value="{{$goodsInfo['goods_id']}}">

        <p>满减:满<input type="text" style="width: 35px;" id="full_price">元,减<input type="text" style="width: 35px;" id="reduce_price">元</p>

        <p>折扣:满<input type="text" style="width: 35px;" id="fullprice">元，打
            <select name="" id="discount">
                @for($i=99;$i>=50;$i--)
                <option value="{{$i}}">{{$i/10}}</option>
                @endfor
            </select>折
        </p>
        <p>活动到期时间：<input type="date" id="expire"></p>
        <button id="btn">添加</button>

        <script>
            $('#btn').click(function () {
                var full_price = $('#full_price').val(); //满多少
                var reduce_price = $('#reduce_price').val();//减多少
                var fullprice = $('#fullprice').val();//满多少
                var discount = $('#discount').val();//打几折
                var goods_id = $('#goods_id').val();//商品id
                var expire = $('#expire').val();
                $.ajax({
                    url:'/activityAdd',
                    type:'post',
                    data:{full_price:full_price,expire:expire,reduce_price:reduce_price,fullPrice:fullprice,discount:discount,goods_id:goods_id},
                    dataType:'json',
                    success:function (res) {
                        alert(res.msg);
                        history.go(0);
                    }
                })
            })
        </script>
    </div>

@endsection
