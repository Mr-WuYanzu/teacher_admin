


@extends('layouts')

@section('title', 'Laravel学院')

@section('sidebar')
@parent
@endsection

@section('content')
<div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
        <input type="hidden"  id="token" value="{{$_COOKIE['token']??''}}">
        <table border="1">
            <tr>
                <td>商品id</td>
                <td>商品名称</td>
                <td>商品单价</td>
                <td>商品库存</td>
                <td>商品详情</td>
                <td>商品图片</td>
                <td>当前状态</td>
                <td>操作</td>
            </tr>
            @foreach($data as $k=>$v)
            <tr align="center">
                <td>{{$v['goods_id']}}</td>
                <td>{{$v['goods_name']}}</td>
                <td>{{$v['goods_price']}}</td>
                <td>{{$v['goods_stock']}}</td>
                <td>{{$v['goods_desc']}}</td>
                <td><img src="http://img.com/{{$v['goods_img']}}" alt="" width="80" height="80"></td>
                <td
                        @if($v['goods_status']=='已上架')
                        style="color:green;"
                        @elseif($v['goods_status']=='待审核')
                        style="color:green;"
                        @else
                        style="color:red;"
                        @endif
                >{{$v['goods_status']}}</td>
                <td goods_id="{{$v['goods_id']}}" shop_id="{{$v['shop_id']}}">
                    @if($v['goods_status']=='已上架')
                        <button id="btn">点击下架</button>
                        <a href="/activity?goods_id={{$v['goods_id']}}"><button>参与限时活动</button></a>
                    @elseif($v['goods_status']=='审核未通过')
                        <button id="btn1">重新上架</button>
                    @elseif($v['goods_status']=='已下架')
                        <button id="btn1">点击上架</button>
                    @else
                        不可操作
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    <script>
        //点击下架
        $(document).on('click','#btn',function () {
            var _this = $(this);
            var goods_id = _this.parent('td').attr('goods_id');
            var shop_id = _this.parent('td').attr('shop_id');
            var token = $('#token').val();
            //获取父级的上一个元素
            var _status = _this.parent('td').prev('td');
            $.ajax({
                url:'/goodsDown',
                type:'post',
                data:{goods_id:goods_id,shop_id:shop_id,token:token},
                dataType:'json',
                async:false,
                success:function (res) {
                    if(res.status==1000){
                        alert(res.msg);
                        //将父级的上一个元素的内容和文字颜色改一下
                        _status.attr('style','color:red');

                        _status.text('已下架');
                        //再改变一下按钮的文字内容和id
                        _this.next().remove();
                        _this.prop('id','btn1');
                        _this.text('点击上架');

                    }else if(res.status==402){
                        alert(res.msg);
                        location.href='/login';
                    }else{
                        alert(res.msg);
                    }
                }
            })
        })
        //点击上架  重复上边的步骤
        $(document).on('click','#btn1',function () {
            var _this = $(this);
            var goods_id = $(this).parent('td').attr('goods_id');
            var shop_id = $(this).parent('td').attr('shop_id');
            var _status = $(this).parent('td').prev('td');
            var token = $('#token').val();//获取token
            $.ajax({
                url:'/goodsTop',
                type:'post',
                data:{goods_id:goods_id,shop_id:shop_id,token:token},
                dataType:'json',
                async:false,
                success:function (res) {
                    if(res.status==1000){
                        alert(res.msg);
                        _status.attr('style','color:green');
                        _status.text('待审核');
                        // _this.prop('id','btn');
                        _this.parent('td').empty().append('不可操作');
                        // _this.text('点击下架');
                    }else if(res.status==402){
                        alert(res.msg);
                        location.href='/login';
                    }else{
                        alert(res.msg);
                    }
                }
            })
        })
    </script>
</div>
@endsection

