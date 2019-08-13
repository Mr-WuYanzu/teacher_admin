@extends('admin.index')
@section('title', '题库列表')

@section('content')
    <table class="layui-table">
        <colgroup>
            <col width="150">
            <col width="200">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th>科目名称</th>
            <th>操作</th>
        </tr>
        </thead>
        @foreach($res as $k=>$v)
            <tbody>
            <tr>
                <td>{{$v->c_name}}</td>
                <td>
                    <a href="/subject_del/{{$v->c_id}}"><input type="button" value="删除" class="layui-btn layui-btn-danger"></a>
                </td>
            </tr>
            </tbody>
        @endforeach
    </table>


@endsection