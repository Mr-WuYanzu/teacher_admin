@extends('layout.layouts')

@section('content')

<table class="layui-table" lay-skin="nob">
  <colgroup>
    <col width="5">
    <col width="500">
    <col>
  </colgroup>
    <tr>
      <td>讲师名称：</td>
      <td>{{$teacherInfo->t_name}}</td>
    </tr>
    <tr>
      <td>讲师自我介绍：</td>
      <td>
      	{{$teacherInfo->t_desc}}
      </td>
    </tr>
    <tr>
      <td>讲师等级：</td>
      <td>{{$teacherInfo->t_good==1?'普通讲师':'优秀讲师'}}</td>
    </tr>
    <tr>
      <td>讲师头像：</td>
      <td>
      	<img src="{{$teacherInfo->t_img}}">
      </td>
    </tr>
    <tr>
    	<td>
    		<a href="/teacher/balance?t_id={{$teacherInfo->t_id}}" class="layui-btn layui-btn-normal">查询余额</a>
    	</td>
    </tr>
</table>

@endsection