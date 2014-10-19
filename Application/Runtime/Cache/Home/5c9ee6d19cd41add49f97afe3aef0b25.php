<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<link rel="stylesheet" type="text/css" href="/Public/css/bmin.css" />
	<script type="text/javascript" src="/Public/js/jquery.js"></script><script type="text/javascript" src="/Public/js/bmin.js"></script><script type="text/javascript" src="/Public/js/md5.js"></script>
	<link rel="stylesheet" type="text/css" href="/Public/css/mycss.css" />
	<title>Wow物价查询</title>
</head>
<body>
	<script type="text/javascript">
		$(document).ready(function()
		{
			$("#alert").hide();
			$("#waiting").hide();
			$("#sub").focus();
		})
	</script>
	<div class="nav">
		<div class = "subnav">
		<ol class="pull-left breadcrumb">
  			<li><a href="http://wow.caihongxd.com">拍卖行</a></li>
  			<li class="active">登陆</li>
  		</ol>
  		<?php if($uid == ''): ?><a class="pull-right btns" href="http://wow.caihongxd.com/index.php/home/User/login">登陆</a>
  		<?php else: ?>
  		  			<span class="pull-right btns">Hi,&nbsp<a href="http://wow.caihongxd.com/index.php/home/User/profile"><?php echo ($uid); ?></a>!</span><?php endif; ?>
  		</div>
	</div>

	<div id="login" class="cardstyle">
		<form role="form" id="loginform">
  			<div class="form-group">
    			<label>Username:</label>
    			<input type="text" class="form-control" id="usr" name="usr">
  			</div>
  			<div class="form-group">
    			<label>Password:</label>
    			<input type="password" class="form-control" id="pwd" name="pwd">
  			</div>
  			<div id="waiting"><p>正在登陆...</p></div>
  			<div id="alert" class="alertMsg"><p id="msg"></p></div>
  			<div class="btn btn-default pull-left" id="sub">登陆</div>
  			<a class="btn btn-default pull-right" href="http://wow.caihongxd.com/index.php/home/User/register" role="button">注册</a>
		</form>
	</div>
	<script type="text/javascript">
		$('#sub').click(function(){
			$.ajax({
				type:"post",
				url:"http://wow.caihongxd.com/index.php/home/User/check",
				dataType:"JSONP",
				data:{
				"usr":$("#usr").val(),
				"pwd":hex_md5($("#pwd").val())
				},
				beforeSend:function()
				{
					$("#alert").hide();
					$("#waiting").show();
				},
				success:function(data)
				{
					$("#waiting").hide();
					$("#alert").show();
					$("#msg").text(data["info"]);
					if (data["type"] == 0)
					{
						window.location.href='http://wow.caihongxd.com';
					}
				},

			});
		})
	</script>
</body>
</html>