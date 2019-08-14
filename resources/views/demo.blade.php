@extends('layout.layouts')

@section('content')
<form class="layui-form" method="post" action="/currAdd" enctype="multipart/form-data">
	<div class="layui-form-item">
    <label class="layui-form-label">课程名称</label>
    <div class="layui-input-inline">
      <input type="text" name="curr_name" id="curr_name" placeholder="请输入课程名称" autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">课程图片</label>
    <div class="layui-input-inline">
      <input type="file" name="curr_img" autocomplete="off" class="layui-input">
    </div>
  </div>
<div class="layui-form-item">
    <label class="layui-form-label">是否付费</label>
    <div class="layui-input-block">
      <input type="radio" class="is_pay" lay-filter='is_pay' name="is_pay" value="2" title="是">
      <input type="radio" class="is_pay" lay-filter='is_pay' name="is_pay" value="1" title="否" checked>
    </div>
  </div>
  <div class="layui-form-item" id="price_div" style="display:none;">
    <label class="layui-form-label">课程价格</label>
    <div class="layui-input-inline">
      <input type="text" name="curr_price" placeholder="请输入价格" autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item layui-form-text">
    <label class="layui-form-label">请填写描述</label>
    <div class="layui-input-block">
      <textarea placeholder="请输入内容" name="curr_detail" class="layui-textarea"></textarea>
    </div>
  </div>
  <div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn" id="sub" lay-submit lay-filter="*">立即提交</button>
      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
    </div>
  </div>
  <!-- 更多表单结构排版请移步文档左侧【页面元素-表单】一项阅览 -->
</form>

<script type="text/javascript">
	$(function(){
		layui.use(['layer','form'],function(){
			var layer=layui.layer;
			var form=layui.form;

			form.on('radio(is_pay)',function(data){
				var val=data.value;
				if(val==2){
					$('#price_div').prop('style','display:block');
				}else if(val==1){
					$('#price_div').prop('style','display:none');
				}
			});

			// $('#sub').click(function(){
			// 	var curr_name=$('#curr_name').val();
			// 	var reg=/^.{2,}$/;
			// 	var flag=false;

			// 	if(curr_name==''){
			// 		layer.msg('课程名称必填',{icon:5,time:1000});
			// 		return false;
			// 	}else if(!reg.test(curr_name)){
			// 		layer.msg('课程名称格式不正确',{icon:5,time:1000});
			// 		return false;
			// 	}else{
			// 		// $.ajax({
			// 		// 	url:'checkCurrName',
			// 		// 	method:'post',
			// 		// 	async:false,
			// 		// 	data:{curr_name:curr_name},
			// 		// 	success:function(res){

			// 		// 	},
			// 		// 	dataType:'json'
			// 		// });
			// 		flag==true;
			// 		if(flag==false){
			// 			return false;
			// 		}
			// 	}
			// });
		});
	});
</script>

@endsection