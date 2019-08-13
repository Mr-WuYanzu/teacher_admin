
{{--头部--}}
@section('top')
        <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>教师后台</title>
    <link rel="stylesheet" href="/layui/css/layui.css">
    <script src="{{asset('layui/layui.js')}}"></script>
    <script src="{{asset('js/jquery.js')}}"></script>
</head>
<body class="layui-layout-body">

<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo">教师后台</div>

        <!-- 头部区域（可配合layui已有的水平导航） -->
        <ul class="layui-nav layui-layout-left">
            <li class="layui-nav-item"><a href="">控制台</a></li>
            <li class="layui-nav-item"><a href="">商品管理</a></li>
            <li class="layui-nav-item"><a href="">用户</a></li>
            <li class="layui-nav-item">
                <a href="javascript:;">其它系统</a>
                <dl class="layui-nav-child">
                    <dd><a href="">邮件管理</a></dd>
                    <dd><a href="">消息管理</a></dd>
                    <dd><a href="">授权管理</a></dd>
                </dl>
            </li>
        </ul>
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;">
                    <img src="http://t.cn/RCzsdCq" class="layui-nav-img">
                    贤心
                </a>
                <dl class="layui-nav-child">
                    <dd><a href="">基本资料</a></dd>
                    <dd><a href="">安全设置</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item"><a href="">退了</a></li>
        </ul>
    </div>
    @show

    {{--左侧--}}
    @section('left')
        <div class="layui-side layui-bg-black">
            <div class="layui-side-scroll">
                <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
                <ul class="layui-nav layui-nav-tree"  lay-filter="test">

                    <li class="layui-nav-item">
                        <a href="javascript:;">题目管理</a>
                        <dl class="layui-nav-child">
                            <dd><a href="/subject">添加题目分类</a></dd>
                            <dd><a href="/subject_list">题目分类列表</a></dd>
                        </dl>
                    </li>

                    <li class="layui-nav-item">
                        <a href="javascript:;">试题管理</a>
                        <dl class="layui-nav-child">
                            <dd><a href="/test">添加试题</a></dd>
                            <dd><a href="list_test">试题列表</a></dd>
                        </dl>
                    </li>

                    <li class="layui-nav-item">
                        <a href="javascript:;">课程分类管理</a>
                        <dl class="layui-nav-child">
                            <dd><a href="/currcate/add">课程分类添加</a></dd>
                            <dd><a href="/currcate/list">课程分类列表</a></dd>
                        </dl>
                    </li>

                    <li class="layui-nav-item">
                        <a href="javascript:;">课程管理</a>
                        <dl class="layui-nav-child">
                            <dd><a href="/currchapter/add">课程章节添加</a></dd>
                            <dd><a href="/currchapter/list">课程章节列表</a></dd>
                        </dl>
                    </li>

                    <li class="layui-nav-item">
                        <a href="javascript:;">订单管理</a>
                        <dl class="layui-nav-child">
                            <dd><a href="/order">订单列表</a></dd>
                        </dl>
                    </li>
                </ul>
            </div>
        </div>
    @show

    {{--主体--}}
    <div class="layui-body">
        <div style="padding: 15px;">@yield('content')</div>
    </div>

    {{--底部--}}
    @section('footer')
        <div class="layui-footer">
            <!-- 底部固定区域 -->
            © layui.com - 底部固定区域
        </div>
</div>
<script>
    //JavaScript代码区域
    layui.use('element', function(){
        var element = layui.element;
    });
</script>
</body>
</html>
@show