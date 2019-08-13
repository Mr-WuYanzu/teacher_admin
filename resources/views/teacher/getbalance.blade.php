@extends('layout.layouts')

@section('content')

<form class="layui-form" action="">
  <div class="layui-form-item">
    <label class="layui-form-label">选择讲师</label>
    <div class="layui-input-inline">
      <select name="teacher" lay-filter="teacher" lay-verify="required">
        <option value="">请选择讲师</option>
        @foreach($teacherInfo as $v)
        <option value="{{$v['t_id']}}">{{$v['t_name']}}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="layui-form-item" id="bal_div" style="display:none;">
    <label class="layui-form-label">讲师余额</label>
    <div class="layui-input-inline">
      <input type="text" id="balance" name="t_balance" required readonly="readonly"  lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
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

			//选择讲师,展示余额
			form.on('select(teacher)',function(data){
				var t_id=data.value;

				if(t_id==''){
					layer.msg('请先选择讲师',{icon:5,time:1000});
					$('#balance').val('');
					$('#bal_div').hide();
					return false;
				}

				$.post(
					'getBalance',
					{t_id:t_id},
					function(res){
						$('#balance').val(res);
						$('#bal_div').show();
					}
				)

			});
		});
	});
</script>

@endsection