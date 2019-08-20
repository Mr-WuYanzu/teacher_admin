@extends('layout.layouts')

@section('content')

<form class="layui-form" action="">
  <div class="layui-form-item">
    <label class="layui-form-label">选择课程</label>
    <div class="layui-input-inline">
      <select name="curr_id" id="curr_id" lay-filter='curr' lay-verify="required">
      	<option value="">请选择课程</option>
        @foreach($currInfo as $v)
        <option value="{{$v['curr_id']}}">{{$v['curr_name']}}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">选择章节</label>
    <div class="layui-input-inline">
      <select name="chapter_id" id="chapter_id" lay-filter='chapter' lay-verify="required">
      	<option value="">请选择章节</option>
      </select>
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">选择课时</label>
    <div class="layui-input-inline">
      <select name="class_id" id="class_id" lay-filter='class' lay-verify="required">
      	<option value="">请选择课时</option>
      </select>
    </div>
  </div>
    <div class="layui-form-item">
    <label class="layui-form-label">测试视频</label>
    <div class="layui-input-block" id="class_video">
    </div>
  </div>
  <div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
    </div>
  </div>
</form>

<script type="text/javascript">
	$(function(){
		layui.use(['layer','form'],function(){
			var layer=layui.layer;
			var form=layui.form;

			//选择课程,展示课程下的章节
			form.on('select(curr)',function(data){
				var curr_id=data.value;

				if(curr_id==''){
					layer.msg('请选择一个课程',{icon:5,time:1000});
					$('#chapter_id').empty();
					$('#chapter_id').append(new Option('请选择章节',''));
					$('#class_id').empty();
					$('#class_id').append(new Option('请选择课时',''));
					$('#class_video').empty();
					form.render();
					return false;
				}

				$.post(
					'getChapter',
					{curr_id:curr_id},
					function(res){
						if(res!=2){
							for(i in res){
								$('#chapter_id').append(new Option(res[i]['chapter_name'],res[i]['chapter_id']));
							}
						}else{
							$('#chapter_id').empty();
							$('#chapter_id').append(new Option('请选择章节',''));
						}
						form.render();
					}
				)
			});

			//选择章节,展示章节下的课时
			form.on('select(chapter)',function(data){
				var chapter_id=data.value;

				if(chapter_id==''){
					$('#class_id').empty();
					$('#class_id').append(new Option('请选择课时',''));
					$('#class_video').empty();
					form.render();
					layer.msg('请选择一个章节',{icon:5,time:1000});
					return false;
				}

				$.post(
					'getClass',
					{chapter_id:chapter_id},
					function(res){
						if(res!=2){
							for(i in res){
								$('#class_id').append(new Option(res[i]['class_name'],res[i]['class_id']));
							}
						}else{
							$('#class_id').empty();
							$('#class_id').append(new Option('请选择课时',''));
						}
						form.render();
					}
				)
			});

			//选择课时,展示课时下的视频
			form.on('select(class)',function(data){
				var class_id=data.value;

				if(class_id==''){
					layer.msg('请选择一个课时',{icon:5,time:1000});
					$('#class_video').empty();
					form.render();
					return false;
				}

				$.post(
					'getVideo',
					{class_id:class_id},
					function(res){
						if(res!=2){
							var _video="<video controls='controls' src='http://curr.video.com/"+res+"'></video>";
							if($('#class_video').children().is('video')!=true){
								$('#class_video').append(_video);
							}
						}else{
							layer.msg('该课时暂无视频,请选择其他课时',{icon:5,time:1000});
							$('#class_video').empty();
						}
						form.render();
					}
				)
			});

		});
	});
</script>

@endsection