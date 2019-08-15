@extends('layout.layouts')

@section('title', '章节课时视频上传')

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
            <p>请选择课时：<select name="class_id" id="classHour">
                    <option value="">--请选择--</option>
                </select>
            </p>
            <p>
                <input type="file" name="file" id="file" style="display: none">
                <button id="sub" class="layui-btn layui-btn-sm">选择文件</button>
                <button id="btn" class="layui-btn">点击上传</button>
                <input type="hidden" id="video_url">
            </p>

            <button id="sub1" class="layui-btn layui-btn-normal">提交</button>

            <script>
                $(function () {
                    layui.use(['form','layer'], function(){
                        var form = layui.form;
                        var layer = layui.layer;

                    //选择课程获得章节
                    $(document).on('change', '#curr', function () {
                        var curr_id = $(this).val();//课程id
                        var _select = "<option>--请选择--</option>";
                        var _chapt = $('#chapt');
                        var _classHour = $('#classHour');
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
                                    _classHour.empty();
                                    _chapt.append(_select);
                                } else {
                                    _chapt.empty();
                                    _classHour.empty();
                                    alert(res.msg);
                                }
                            }
                        })
                    })
                    //选择章节获得课时
                    $(document).on('change', '#chapt', function () {
                        var chapter_id = $(this).val();
                        var curr_id = $('#curr').val();
                        var classNUm = $('#class_num');
                        var _select = "<option>--请选择--</option>";
                        var classHour = $('#classHour');
                        //获取此章节下的课时
                        $.ajax({
                            url: '/getClassHour',
                            type: 'post',
                            data: {curr_id: curr_id, chapter_id: chapter_id},
                            dataType: 'json',
                            success: function (res) {
                                if (res.status == 200) {
                                    for (i = 0; i < res.data.length; i++) {
                                        _select += "<option value='" + res.data[i].class_id + "'>" + res.data[i].class_name + "</option>"
                                    }
                                    classHour.empty();
                                    classHour.append(_select);
                                } else {
                                    classHour.empty();
                                    alert(res.msg);
                                }
                            }
                        })
                    })
                    //点击选择文件
                    $('#sub').click(function () {
                        $('input[type="file"]').click();
                    })
                    //点击上传文件
                    $('#btn').click(function () {
                        var file = $('input[type="file"]')[0].files[0];
                        if($('input[type="file"]')[0].files.length<1){
                            alert('请选择文件上传');
                            return;
                        }
                        var _video = $('#video_url');
                        var chunkSize = 5*1024*1024;
                        var chunks = Math.ceil(file.size/chunkSize);
                        var start = 0;
                        var end = 0;
                        var point = localStorage.getItem(file.name);
                        if(point === null){
                            for(var i=0;i<chunks;i++){
                                start=i*chunkSize;
                                end = (start+chunkSize) > file.size ? file.size : (start+chunkSize);
                                var content = file.slice(start,end);
                                var formData = new FormData();
                                formData.append('file',content);
                                formData.append('name',file.name);
                                formData.append('size',file.size);
                                formData.append('currentChunk',i);
                                formData.append('chunks',chunks);
                                $.ajax({
                                    url: "/videoUpload",
                                    type: 'post',
                                    data:formData,
                                    processData: false,
                                    contentType: false,
                                    dataType: 'json',
                                    success:function (data) {
                                        console.log(data);
                                        if(data.status==200){
                                            layer.msg('上传成功',{icon:1});
                                            _video.val(data[0].path+data[0].fileName);
                                            localStorage.clear(file.name);
                                        }else if(data.status==201){
                                            var chun = localStorage.getItem(file.name);
                                            if(chun === null){
                                                chun = '';
                                            }
                                            chun += data[0].currentChunk+',';
                                            localStorage.setItem(file.name,chun);
                                        }else{
                                            layer.msg('上传失败',{icon:5});
                                        }
                                    },
                                    error:function (error) {
                                        // alert(error);
                                    }
                                })

                            }
                        }else{
                            var ar = point.split(',');

                            for(var i=0;i<chunks;i++){
                                //未上传的接着上传
                                if(inarray(ar,i)<0){
                                    start=i*chunkSize;
                                    end = (start+chunkSize) > file.size ? file.size : (start+chunkSize);
                                    var content = file.slice(start,end);
                                    var formData = new FormData();
                                    formData.append('file',content);
                                    formData.append('name',file.name);
                                    formData.append('size',file.size);
                                    formData.append('currentChunk',i);
                                    formData.append('chunks',chunks);
                                    $.ajax({
                                        url: "/videoUpload",
                                        type: 'post',
                                        data:formData,
                                        processData: false,
                                        contentType: false,
                                        dataType: 'json',
                                        success:function (data) {
                                            if(data.status==200){
                                                layer.msg('上传成功',{icon:1});
                                                _video.val(data[0].path+data[0].fileName);
                                                localStorage.clear(file.name);
                                            }else if(data.status==201){
                                                var chun = localStorage.getItem(file.name);
                                                if(chun === null){
                                                    chun = '';
                                                }
                                                chun += data[0].currentChunk+',';
                                                localStorage.setItem(file.name,chun);
                                            }else{
                                                layer.msg('上传失败',{icon:5});
                                            }
                                        },
                                        error:function (error) {
                                            // alert(error);
                                        }
                                    })
                                }


                            }
                        }
                        function inarray(arr,e)
                        {
                            var res = -1;
                            arr.forEach(function(v,k){
                                if(v == e ){
                                    res = 1;
                                }
                            })
                            return res;
                        }



                    })


                    //添加提交
                    $(document).on('click', '#sub1', function () {
                        var chapter_id = $('#chapt').val();
                        var class_id = $('#classHour').val();
                        var curr_id = $('#curr').val();
                        var video_url = $('#video_url').val();
                        $.ajax({
                            url:"/videoAdd",
                            type:'post',
                            data:{chapter_id:chapter_id,curr_id:curr_id,video_url:video_url,class_id:class_id},
                            dataType:'json',
                            success:function (res) {
                                if(res.status==200){
                                    layer.msg('添加成功请等待审核',{icon:1},function () {
                                        history.go(0);
                                    });
                                }else{
                                    layer.msg(res.msg,{icon:5});
                                }
                            }
                        })
                    })
                })
                });
            </script>
        </div>
        </p>

@endsection