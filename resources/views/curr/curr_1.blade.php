@extends('layout.layouts')

@section('title', '课程添加')

@section('sidebar')
    @parent
@endsection

@section('content')
        <p>
        <form class="layui-form" action="/currAdd" method="post" enctype="multipart/form-data" >
            <div class="layui-form-item">
                <label class="layui-form-label">课程名称</label>
                <div class="layui-input-inline">
                    <input type="text" id="curr_name" name="curr_name" required  lay-verify="required" placeholder="请输入课程名称" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">课程分类</label>
                <div class="layui-input-inline">
                    <select name="curr_cate_id" lay-verify="required">
                        <option value=""></option>
                        @foreach($cateInfo as $k=>$v)
                        <option value="{{$v['curr_cate_id']}}"><?php echo str_repeat('&nbsp;',$v['level']*6);?>{{$v['cate_name']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">课程图片</label>
                <div class="layui-input-inline">
                   <input type="file" id="curr_img" name="curr_img" required  lay-verify="required" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">是否付费</label>
                <div class="layui-input-block">
                    <input type="radio" name="is_pay" value="2" title="是" class="is_pay"  lay-filter="is_pay">
                    <input type="radio" name='is_pay' value="1" title="否" class="is_pay"   lay-filter="is_pay"  checked>
                </div>
            </div>
            <div class="layui-form-item" style="display:none" id="price">
                <label class="layui-form-label">课程价格</label>
                <div class="layui-input-inline">
                    <input type="text" name="price" required  placeholder="请输入课程的价格" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">课程介绍</label>
                <div class="layui-input-block">
                    <textarea name="curr_detail" placeholder="介绍一下此课程吧" class="layui-textarea"></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" id="sub">提交</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        </form>
        <script>
            //Demo
            $(function(){
                layui.use(['layer','form'], function(){
                    var form = layui.form;
                    var layer = layui.layer;
                    form.on('radio(is_pay)', function(data){
                        var val = (data.value); //被点击的radio的value值
                        if(val == 2){
                            $('#price').prop('style','display:block');
                        }else{
                            $('#price').prop('style','display:none');
                        }
                    });

                    $('#sub').click(function(){
                    //     var curr_name=$('#curr_name').val();
                    //     var reg=/^.{2,}$/;
                    //     var flag=false;
                    //     if(curr_name==''){
                    //         layer.msg('课程名称必填',{icon:5,time:1000});
                    //         return false;
                    //     }else if(!reg.test(curr_name)){
                    //         layer.msg('课程名称格式不正确',{icon:5,time:1000});
                    //         return false;
                    //     }else{
                    //         $.ajax({
                    //             url:'/curr/checkCurrName',
                    //             method:'post',
                    //             async:false,
                    //             data:{curr_name:curr_name},
                    //             success:function(res){
                    //                 if(res.code==2){
                    //                     layer.msg('课程名称已被占用',{icon:res.skin,time:1000});
                    //                     flag=false;
                    //                 }else{
                    //                     flag=true;
                    //                 }
                    //             },
                    //             dataType:'json'
                    //         });

                    //         if(flag==false){
                    //             return false;
                    //         }else{
                                $('form').submit();
                    //         }
                    //     }

                        
                    });

                    // //监听提交
                    // form.on('submit(formDemo)', function(data){
                        // $.ajax({
                        //     url:'/currAdd',
                        //     type:'post',
                        //     data:data.field,
                        //     dataType:'json',
                        //     success:function (res) {
                        //         alert(res.msg);
                        //         history.go(0);
                        //     }
                        // })
                        // return false;
                    // });
                });
            });
            
        </script>

        </p>

@endsection