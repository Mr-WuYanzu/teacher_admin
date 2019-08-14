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
        <input type="hidden" value="" id="video_url">
            <p>当前的课时：<span id="class_num"></span></p>
            <p>课时的名称：<input type="text" id="class_hour_name"></p>
            <p>请选择课时类型：
                <input type="radio" name="class_type" value="1" class="class_type">直播课程 
                <input type="radio" name="class_type" value="2" class="class_type" checked>录播课程
            </p>
            <div id="upl">
                    <form id="uploadForm" enctype="multipart/form-data">
                        文件:<input id="file" type="file" name="file"/>
                    </form>
                    <button id="upload">上传文件</button>

            </div>
            <button id="sub">提交</button>

        <script>
            $(function () {
                $('.class_type').click(function () {
                    var _val = $(this).val();
                    if(_val==1){
                        $('#upl').empty();
                        var _div="<div>直播地址:<input type=\"text\" id=\"live_url\"/></div>";
                        $('#upl').append(_div);
                    }else if(_val==2){
                        $('#upl').empty();
                        var _div="<form id=\"uploadForm\" enctype=\"multipart/form-data\">\n" +
                            "                        文件:<input id=\"file\" type=\"file\" name=\"file\"/>\n" +
                            "                    </form>\n" +
                            "                    <button id=\"upload\">上传文件</button><input type='hidden' id='video_url'>";
                        $('#upl').append(_div);
                    }
                })
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
                        var video_url = null;
                        var live_url = null;
                        var class_type=0;
                        //获取用户课程类型
                        var _type = $('.class_type');
                        _type.each(function (index) {
                            if($(this).prop('checked')==true){
                                class_type=$(this).val();
                                if(class_type==1){
                                    live_url = $('#live_url').val();
                                }else if(class_type==2){
                                    video_url = $('#video_url').val();
                                }
                            }

                        })
                        if(video_url==null&&live_url==null){
                            alert('请选择上传视频或者填写直播地址');
                            return false;
                        }
                        $.ajax({
                            url:'/classHourAdd',
                            type:'post',
                            data:{chapter_id:chapter_id,class_hour_name:class_hour_name,curr_id:curr_id,video_url:video_url,live_url:live_url,class_type:class_type},
                            dataType:'json',
                            success:function (index) {
                                alert(index.msg);
                                if(index.status==200){
                                    history.go(0);
                                }
                            }
                        })

                    })
                })
            </script>
        </div>
        </p>

@endsection