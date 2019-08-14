<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="/layui/css/layui.css">
    <script src="/layui/layui.js"></script>
    <script src="/js/jquery.js"></script>
</head>
<body class="layui-layout-body">
@section('sidebar')
    <div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo">layui 后台布局</div>
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
                    {{--<img src="http://t.cn/RCzsdCq" class="layui-nav-img">--}}
                    @if(session('user'))
                    {{session('user')['user_name']}}
                    @endif
                </a>
                <dl class="layui-nav-child">
                    <dd><a href="">基本资料</a></dd>
                    <dd><a href="">安全设置</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item"><a href="/login/quitLogin">退出</a></li>
        </ul>
    </div>

        <div class="layui-side layui-bg-black">
            <div class="layui-side-scroll">
                <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
                <ul class="layui-nav layui-nav-tree"  lay-filter="test">
                    <li class="layui-nav-item layui-nav-itemed">
                        <a class="" href="javascript:;">讲师管理</a>
                        <dl class="layui-nav-child">
                            @if(empty(session('user')))
                            <dd><a href="/apply">申请成为讲师</a></dd>
                            @else
                            <dd><a href="/teacher/center">个人中心</a></dd>
                            <dd><a href="/teacher/balance">查询余额</a></dd>
                            @endif
                        </dl>
                    </li>
                    <li class="layui-nav-item">
                        <a class="" href="javascript:;">课程管理</a>
                        <dl class="layui-nav-child">
                            <dd><a href="/curr">课程添加</a></dd>
                            <dd><a href="/currList">课程列表</a></dd>
                            <dd><a href="/chapter">章节添加</a></dd>
                            <dd><a href="/classHour">课时添加</a></dd>
                        </dl>
                    </li>
                    <li class="layui-nav-item">
                        <a class="" href="javascript:;">在线测试</a>
                        <dl class="layui-nav-child">
                            <dd><a href="/test/test">课程测试</a></dd>
                        </dl>
                    </li>

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
                        <a href="javascript:;">订单管理</a>
                        <dl class="layui-nav-child">
                            <dd><a href="/order">订单列表</a></dd>
                        </dl>
                    </li>


                </ul>
            </div>
        </div>
@show

<div class="container">
        <div class="layui-body">
            @yield('content')
        </div>

        <div class="layui-footer">
            <!-- 底部固定区域 -->
            © layui.com - 底部固定区域
        </div>
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