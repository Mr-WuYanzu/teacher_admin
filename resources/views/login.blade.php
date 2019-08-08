<!DOCTYPE html>
<html lang="en">
<head>

    <title>Video.js | HTML5 Video Player</title>

    <link href="http://vjs.zencdn.net/5.20.1/video-js.css" rel="stylesheet">
    <script src="http://vjs.zencdn.net/5.20.1/videojs-ie8.min.js"></script>
    
</head>
<body>

  <video id="example_video_1" class="video-js vjs-default-skin" controls preload="auto" width="1280" height="720" poster="http://vjs.zencdn.net/v/oceans.png" data-setup="{}">
    <!-- <source src="1.mp4" type="video/mp4"> -->
   
<source src="http://192.168.136.135/cctvf/zhb.m3u8" type='application/x-mpegURL'> 
    <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
  </video>
  
  <script src="http://vjs.zencdn.net/5.20.1/video.js"></script>
</body>

</html>















<table>
        <tr>
            <td>用户名</td>
            <td><input type="text" id="user_name"></td>
        </tr>
        <tr>
            <td>密码</td>
            <td><input type="password" id="user_pwd"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="登录" id="login"></td>
        </tr>
</table>

<script src="/js/jquery.js"></script>
<script>
    $('#login').click(function () {
        var user_name = $('#user_name').val();
        var user_pwd = $('#user_pwd').val();
        $.ajax({
            url:'/sendLogin',
            type:'post',
            data:{user_name:user_name,user_pwd:user_pwd},
            dataType:'json',
            success:function (res) {
                if(res.status!=1000){
                    alert(res.msg);
                }else{
                    alert('登录成功');
                    location.href='/admin';
                }
            }
        })
    })
</script>