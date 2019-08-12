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
            <p>请选择课时类型：<input type="radio" name="class_type" value="1" class="class_type">直播课程 <input type="radio" name="class_type" value="2" class="class_type" checked>录播课程</p>
            <p>
                <input type="file" name="file" accept="image/*" id="file" style="display: none">
                <button id="sub1">选择文件</button>
                <button id="btn">点击上传</button>
            </p>
            <button id="sub">提交</button>

        <script>
            $('#sub1').click(function () {
                $('#file').click();
            })
            $('#btn').click(function () {
                var file = $('#file').val();

            })
        </script>













            {{--<script>--}}
                {{--$(function () {--}}
                    {{--//选择课程--}}
                    {{--$(document).on('change', '#curr', function () {--}}
                        {{--var curr_id = $(this).val();//课程id--}}
                        {{--var _select = "<option>--请选择--</option>";--}}
                        {{--var _chapt = $('#chapt');--}}
                        {{--//获取当前课程的章节内容--}}
                        {{--$.ajax({--}}
                            {{--url: '/getChapter',--}}
                            {{--type: 'post',--}}
                            {{--data: {curr_id: curr_id},--}}
                            {{--async: false,--}}
                            {{--dataType: 'json',--}}
                            {{--success: function (res) {--}}
                                {{--if (res.status == 200) {--}}
                                    {{--for (i = 0; i < res.data.length; i++) {--}}
                                        {{--_select += "<option value='" + res.data[i].chapter_id + "'>" + res.data[i].chapter_name + "</option>"--}}
                                    {{--}--}}
                                    {{--_chapt.empty();--}}
                                    {{--_chapt.append(_select);--}}
                                {{--} else {--}}
                                    {{--_chapter.empty();--}}
                                    {{--alert(res.msg);--}}
                                {{--}--}}
                            {{--}--}}
                        {{--})--}}
                    {{--})--}}
                    {{--//选择章节--}}
                    {{--$(document).on('change', '#chapt', function () {--}}
                        {{--var chapter_id = $(this).val();--}}
                        {{--var curr_id = $('#curr').val();--}}
                        {{--var classNUm = $('#class_num');--}}
                        {{--//获取当前要添加的课时号--}}
                        {{--$.ajax({--}}
                            {{--url: '/classHourNum',--}}
                            {{--type: 'post',--}}
                            {{--data: {curr_id: curr_id, chapter_id: chapter_id},--}}
                            {{--dataType: 'json',--}}
                            {{--success: function (res) {--}}
                                {{--if (res.status == 200) {--}}
                                    {{--classNUm.empty();--}}
                                    {{--classNUm.text('第' + res.classNum + '课时');--}}
                                {{--} else {--}}
                                    {{--alert(res.msg);--}}
                                {{--}--}}
                            {{--}--}}
                        {{--})--}}
                    {{--})--}}
                    {{--//添加提交--}}
                    {{--$(document).on('click', '#sub', function () {--}}
                        {{--var chapter_id = $('#chapt').val();--}}
                        {{--var curr_id = $('#curr').val();--}}
                        {{--var class_hour_name = $('#class_hour_name').val();--}}
                        {{--var video_url = $('#video_url').val();--}}
                        {{--var class_ = $('.class_type');--}}
                        {{--var class_type='';--}}
                        {{--class_.each(function (index) {--}}
                            {{--if($(this).prop('checked')==true){--}}
                              {{--class_type=$(this).val();--}}
                            {{--}--}}
                        {{--})--}}
                        {{--$.ajax({--}}
                            {{--url: '/classHourAdd',--}}
                            {{--type: 'post',--}}
                            {{--data: {chapter_id: chapter_id, curr_id: curr_id, class_hour_name: class_hour_name,video_url:video_url,class_type:class_type},--}}
                            {{--dataType: 'json',--}}
                            {{--success: function (res) {--}}
                                {{--alert(res.msg);--}}
                                {{--if (res.status == 200) {--}}
                                    {{--history.go(0);--}}
                                {{--}--}}
                            {{--}--}}
                        {{--})--}}
                    {{--})--}}
                    {{--var arr = [];--}}
                    {{--$(document).on('click','#sub1',function () {--}}
                        {{--$('input[type="file"]').click();--}}
                    {{--})--}}
                    {{--$(document).on('click','#btn',function () {--}}
                        {{--var file = $('input[type="file"]')[0].files[0];--}}
                        {{--var url='';--}}
                        {{--var video_url = $('#video_url');--}}
                        {{--if ($('input[type="file"]')[0].files.length < 1) {--}}
                            {{--alert('请选择文件上传');--}}
                            {{--return;--}}
                        {{--}--}}
                        {{--var chunkSize = 2 * 1024 * 1024;--}}
                        {{--var chunks = Math.ceil(file.size / chunkSize);--}}
                        {{--var start = 0;--}}
                        {{--var end = 0;--}}
                        {{--var point = localStorage.getItem(file.name);--}}
                        {{--if (point === null) {--}}
                            {{--for (var i = 0; i < chunks; i++) {--}}
                                {{--start = i * chunkSize;--}}
                                {{--end = (start + chunkSize) > file.size ? file.size : (start + chunkSize);--}}
                                {{--var content = file.slice(start, end);--}}
                                {{--var formData = new FormData();--}}
                                {{--formData.append('file', content);--}}
                                {{--formData.append('name', file.name);--}}
                                {{--formData.append('size', file.size);--}}
                                {{--formData.append('currentChunk', i);--}}
                                {{--formData.append('chunks', chunks);--}}
                                {{--$.ajax({--}}
                                    {{--url: "/upload",--}}
                                    {{--type: 'post',--}}
                                    {{--data: formData,--}}
                                    {{--processData: false,--}}
                                    {{--contentType: false,--}}
                                    {{--dataType: 'json',--}}
                                    {{--success: function (data) {--}}
                                        {{--if (data.status == 200) {--}}
                                            {{--url+=data.data.path+data.data.fileName;--}}
                                            {{--video_url.val(null);--}}
                                            {{--video_url.val(url);--}}
                                            {{--alert('上传成功');--}}
                                            {{--localStorage.clear(file.name);--}}
                                        {{--} else if (data.status == 201) {--}}
                                            {{--var chun = localStorage.getItem(file.name);--}}
                                            {{--if (chun === null) {--}}
                                                {{--chun = '';--}}
                                            {{--}--}}
                                            {{--chun += data.data[0].currentChunk + ',';--}}
                                            {{--localStorage.setItem(file.name, chun);--}}
                                        {{--} else {--}}
                                            {{--alert(上传失败);--}}
                                        {{--}--}}
                                    {{--},--}}
                                    {{--error: function (error) {--}}
                                        {{--// alert(error);--}}
                                    {{--}--}}
                                {{--})--}}

                            {{--}--}}
                        {{--} else {--}}
                            {{--var ar = point.split(',');--}}
                            {{--for (var i = 0; i < chunks; i++) {--}}
                                {{--//未上传的接着上传--}}
                                {{--if (inarray(ar, i) < 0) {--}}
                                    {{--start = i * chunkSize;--}}
                                    {{--end = (start + chunkSize) > file.size ? file.size : (start + chunkSize);--}}
                                    {{--var content = file.slice(start, end);--}}
                                    {{--var formData = new FormData();--}}
                                    {{--formData.append('file', content);--}}
                                    {{--formData.append('name', file.name);--}}
                                    {{--formData.append('size', file.size);--}}
                                    {{--formData.append('currentChunk', i);--}}
                                    {{--formData.append('chunks', chunks);--}}
                                    {{--$.ajax({--}}
                                        {{--url: "http://www.apitest.com/index.php?c=upload&a=test",--}}
                                        {{--type: 'post',--}}
                                        {{--data: formData,--}}
                                        {{--processData: false,--}}
                                        {{--contentType: false,--}}
                                        {{--dataType: 'json',--}}
                                        {{--success: function (data) {--}}
                                            {{--console.log(data);--}}
                                            {{--if (data.status == 200) {--}}
                                                {{--url+=data.data.path+data.data.fileName;--}}
                                                {{--video_url.val(null);--}}
                                                {{--video_url.val(url);--}}
                                                {{--alert('上传成功');--}}
                                                {{--localStorage.clear(file.name);--}}
                                            {{--} else if (data.status == 201) {--}}
                                                {{--var chun = localStorage.getItem(file.name);--}}
                                                {{--if (chun === null) {--}}
                                                    {{--chun = '';--}}
                                                {{--}--}}
                                                {{--chun += data.data[0].currentChunk + ',';--}}
                                                {{--localStorage.setItem(file.name, chun);--}}
                                            {{--} else {--}}
                                                {{--alert(上传失败);--}}
                                            {{--}--}}
                                        {{--},--}}
                                        {{--error: function (error) {--}}
                                            {{--// alert(error);--}}
                                        {{--}--}}
                                    {{--})--}}
                                {{--}--}}


                            {{--}--}}
                        {{--}--}}

                        {{--function inarray(arr, e) {--}}
                            {{--var res = -1;--}}
                            {{--arr.forEach(function (v, k) {--}}
                                {{--if (v == e) {--}}
                                    {{--res = 1;--}}
                                {{--}--}}
                            {{--})--}}
                            {{--return res;--}}
                        {{--}--}}


                    {{--})--}}
                {{--})--}}
            {{--</script>--}}
        </div>
        </p>

@endsection