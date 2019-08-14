@extends('layout.layouts')

@section('title', '课程添加')

@section('sidebar')
    @parent
@endsection

@section('content')

<form class="layui-form" method="post" action="/currAdd" enctype="multipart/form-data"> <!-- 提示：如果你不想用form，你可以换成div等任何一个普通元素 -->
  <div class="layui-form-item">
    <label class="layui-form-label">课程名称</label>
    <div class="layui-input-inline">
      <input type="text" name="curr_name" placeholder="请输入课程名称" autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">课程分类</label>
    <div class="layui-input-inline">
      <select name="curr_cate_id" lay-filter="aihao">
        <option value="">请选择分类</option>
        @foreach($cateInfo as $v)
        <option value="{{$v['curr_cate_id']}}"><?php echo str_repeat('&nbsp;',$v['level']*6);?>{{$v['cate_name']}}</option>
        @endforeach
      </select>
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
      <button class="layui-btn" lay-submit lay-filter="*">立即提交</button>
      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
    </div>
  </div>
  <!-- 更多表单结构排版请移步文档左侧【页面元素-表单】一项阅览 -->
</form>

<script type="text/javascript">
    $(function(){
        layui.use(['layer','form'],function(){
            var layer = layui.layer;
            var form = layui.form;

            form.on('radio(is_pay)',function(data){
                var val=data.value;
                if(val==2){
                    $('#price_div').prop('style','display:block');
                }else if(val==1){
                    $('#price_div').prop('style','display:none');
                }
            });

        });
    });
</script>

@endsection