<!DOCTYPE HTML>
<html lang="zxx">

<head>
	<title>Home</title>
	<!-- Meta tag Keywords -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8" />
	<meta name="keywords" content=""
	/>
	<script>
		addEventListener("load", function () {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
	<!-- Meta tag Keywords -->
	<!-- css files -->
	<link rel="stylesheet" href="{{asset('css/style.css')}}" type="text/css" media="all" />
	<!-- Style-CSS -->
	<link rel="stylesheet" href="{{asset('css/fontawesome-all.css')}}">
	<!-- Font-Awesome-Icons-CSS -->
	<!-- //css files -->
	<!-- web-fonts -->
	<link href="http://maxcdn.bootstrapcdn.com/css?family=Josefin+Sans:100,100i,300,300i,400,400i,600,600i,700,700i" rel="stylesheet">
	<link href="http://maxcdn.bootstrapcdn.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
	<link href="/layui/css/layui.css" rel="stylesheet">
	<!-- //web-fonts -->
</head>

<body>
	<!-- bg effect -->
	<div id="bg">
		<canvas></canvas>
		<canvas></canvas>
		<canvas></canvas>
	</div>
	<!-- //bg effect -->
	<!-- title -->
	<h1>Effect Login Form</h1>
	<!-- //title -->
	<!-- content -->
	<div class="sub-main-w3">
			<h2>Login Now
				<i class="fas fa-level-down-alt"></i>
			</h2>
			<div class="form-style-agile">
				<label>
					<i class="fas fa-user"></i>
					Username
				</label>
				<input placeholder="Username" name="account" id="account" type="text" required="">
			</div>
			<div class="form-style-agile">
				<label>
					<i class="fas fa-unlock-alt"></i>
					Password
				</label>
				<input placeholder="Password" name="pwd" id="pwd" type="password" required="">
			</div>
			<!-- checkbox -->
			<div class="wthree-text">
				<ul>
					<li>
						<label class="anim">
							<input type="checkbox" class="checkbox" required="">
							<span>Stay Signed In</span>
						</label>
					</li>
					<li>
						<a href="#">Forgot Password?</a>
					</li>
				</ul>
			</div>
			<!-- //checkbox -->
			<button id="sub" class="layui-btn">logIn</button>

	</div>
	<!-- //content -->

	<!-- copyright -->
	<div class="footer">
		<p>Copyright &copy; 2018.Company name All rights reserved.<a target="_blank" href="http://sc.chinaz.com/moban/">&#x7F51;&#x9875;&#x6A21;&#x677F;</a></p>
	</div>
	<!-- //copyright -->

	<!-- Jquery -->
	<script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
	<!-- //Jquery -->

	<!-- effect js -->
	<script src="{{asset('js/canva_moving_effect.js')}}"></script>
	<!-- //effect js -->
	<script src="{{asset('layui/layui.js')}}"></script>

	<script type="text/javascript">
		$(function(){
			layui.use(['layer'],function(){
				var layer=layui.layer;

				$('#sub').click(function(){
					var obj={};
					obj.account=$('#account').val();
					obj.pwd=$('#pwd').val();

					if(obj.account==''){
						layer.msg('账号必填',{icon:5,time:1000});
						return false;
					}

					if(obj.pwd==''){
						layer.msg('密码必填',{icon:5,time:1000});
						return false;
					}

					$.ajax({
						url:'/login/doLogin',
						type:'post',
						data:{data:obj},
						dataType:'json',
						success:function(res){
							layer.msg(res.font,{icon:res.skin,time:1000},function(){
								if(res.code==1){
									location.href='/teacher/center';
								}else if(res.code==3){
									location.href='/apply';
								}
							});
						},
					})


				});
			});
		});
	</script>
</body>

</html>