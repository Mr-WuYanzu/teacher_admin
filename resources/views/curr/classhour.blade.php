@extends('layout.layouts')

@section('title', '章节课时添加')

@section('sidebar')
    @parent
@endsection

@section('content')
        <p>
        <div style="padding:15px">
                <p>请选择课程：
                <select name="curr_id" id="curr">
                    <option value="">--请选择--</option>
                    @foreach($currInfo as $k=>$v)
                        <option value="{{$v['curr_id']}}">{{$v['curr_name']}}</option>
                    @endforeach
                </select>
            </p>
            <p>请选择章节：<select name="curr_id" id="chapt">
                    <option value="">--请选择--</option>
                </select>
            </p>
            <p>当前的课时：<span id="class_num"></span></p>
            <p>课时的名称：<input type="text" id="class_hour_name"></p>
            <button id="sub">提交</button>

        <script>
            $(function () {
            //视频文件上传
                $(document).on('click','#upload',function () {
                    var formData = new FormData($('#uploadForm')[0]);
                    console.log(formData);
                    var _sub = $('#sub');
                    var _video=$('#video_url');
                    _sub.attr('disabled',true);
                    _sub.text('请等待视频上传完成');
                    $.ajax({
                        type: 'post',
                        url: "/upload", //上传文件的请求路径必须是绝对路劲
                        data: formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        success:function (res) {
                            if(res.status==1000){
                                alert('成功');
                                _video.val(res.filename);
                                _sub.text('提交');
                                _sub.attr('disabled',false);
                            }else{
                                alert(res.msg);
                                _sub.text('提交');
                                _sub.attr('disabled',false);
                            }
                        }
                    })
                });
            });
        </script>
            <script>
                $(function () {
                    //选择课程
                    $(document).on('change', '#curr', function () {
                        var curr_id = $(this).val();//课程id
                        var _select = "<option>--请选择--</option>";
                        var _chapt = $('#chapt');
                        //获取当前课程的章节内容
                        $.ajax({
                            url: '/getChapter',
                            type: 'post',
                            data: {curr_id: curr_id},
                            async: false,
                            dataType: 'json',
                            success: function (res) {
                                if (res.status == 200) {
                                    for (i = 0; i < res.data.length; i++) {
                                        _select += "<option value='" + res.data[i].chapter_id + "'>" + res.data[i].chapter_name + "</option>"
                                    }
                                    _chapt.empty();
                                    _chapt.append(_select);
                                } else {
                                    _chapter.empty();
                                    alert(res.msg);
                                }
                            }
                        })
                    })
                    //选择章节
                    $(document).on('change', '#chapt', function () {
                        var chapter_id = $(this).val();
                        var curr_id = $('#curr').val();
                        var classNUm = $('#class_num');
                        //获取当前要添加的课时号
                        $.ajax({
                            url: '/classHourNum',
                            type: 'post',
                            data: {curr_id: curr_id, chapter_id: chapter_id},
                            dataType: 'json',
                            success: function (res) {
                                if (res.status == 200) {
                                    classNUm.empty();
                                    classNUm.text('第' + res.classNum + '课时');
                                } else {
                                    alert(res.msg);
                                }
                            }
                        })
                    })
                    //添加提交
                    $(document).on('click', '#sub', function () {
                        var chapter_id = $('#chapt').val();
                        var class_hour_name = $('#class_hour_name').val();
                        var curr_id = $('#curr').val();

                        layui.use('form', function(){
                            var form = layui.form;
                            $.ajax({
                                url:'/classHourAdd',
                                type:'post',
                                data:{chapter_id:chapter_id,class_hour_name:class_hour_name,curr_id:curr_id},
                                dataType:'json',
                                success:function (res) {
                                    if(res.status==200){
                                        layer.msg(res.msg,{icon:1},function () {
                                            history.go(0);
                                        });
                                    }else{
                                        layer.msg(res.msg,{icon:5});
                                    }
                                }
                            })
                        });


                    })
                })
            </script>
        </div>
        </p>

@endsection