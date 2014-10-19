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
  			<li class="active">注册</li>
  		</ol>
  		<?php if($uid == ''): ?><a class="pull-right btns" href="http://wow.caihongxd.com/index.php/home/User/login">登陆</a>
  		<?php else: ?>
  		  			<span class="pull-right btns">Hi,&nbsp<a href="http://wow.caihongxd.com/index.php/home/User/profile"><?php echo ($uid); ?></a>!</span><?php endif; ?>
  		</div>
	</div>
	<div id="login" class="cardstyle">
		<form role="form" id="regform">
  			<div class="form-group">
    			<label>Username:</label>
    			<input type="text" class="form-control" id="usr" name="usr">
  			</div>
  			<div class="form-group">
    			<label>Password:</label>
    			<input type="password" class="form-control" id="pwd" name="pwd">
  			</div>
  			<div class="form-group">
    			<label>Confirm:</label>
    			<input type="password" class="form-control" id="cpwd" name="cpwd">
  			</div>
  			<div id="waiting"><p>正在注册...</p></div>
  			<div id="alert" class="alertMsg"><p id="msg"></p></div>
  			<div class="btn btn-default pull-left" id="sub">注册</div>
  			<a class="btn btn-default pull-right" href="http://wow.caihongxd.com/index.php/home/User/login" role="button">登陆</a>
		</form>
	</div>
	<script type="text/javascript">
		$('#sub').click(function(){
			if ($("#usr").val() == "")
			{
				$("#waiting").hide();
				$("#alert").show();
				$("#msg").text("用户名不能为空");
				return;
			}

			if ($("#pwd").val() == "" || $("#cpwd").val() == "")
			{
				$("#waiting").hide();
				$("#alert").show();
				$("#msg").text("密码不能为空");
				return;
			}

			$.ajax({
				type:"post",
				url:"http://wow.caihongxd.com/index.php/home/User/regcheck",
				dataType:"JSONP",
				data:{
				"usr":$("#usr").val(),
				"pwd":hex_md5($("#pwd").val()),
				"cpwd":hex_md5($("#cpwd").val())
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
						setTimeout("window.location.href='http://wow.caihongxd.com/index.php/home/User/login'",3000);
					}
				},

			});
		})
	</script>
</body>
</html>