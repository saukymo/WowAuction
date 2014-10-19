<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<link rel="stylesheet" type="text/css" href="/Public/css/bmin.css" />
	<script type="text/javascript" src="/Public/js/jquery.js"></script><script type="text/javascript" src="/Public/js/bmin.js"></script>
	<link rel="stylesheet" type="text/css" href="/Public/css/mycss.css" />
	<title>Wow物价查询</title>
</head>
<body>
	<div class="nav">
		<div class = "subnav">
		<ol class="pull-left breadcrumb">
  			<li><a href="http://wow.caihongxd.com">拍卖行</a></li>
  			<li class="active">个人信息</li>
  		</ol>
  		<?php if($uid == ''): ?><a class="pull-right btns" href="http://wow.caihongxd.com/index.php/home/User/login">登陆</a>
  		<?php else: ?>
  		  			<span class="pull-right btns">Hi,&nbsp<a href="http://wow.caihongxd.com/index.php/home/User/profile"><?php echo ($uid); ?></a>!</span><?php endif; ?>
  		</div>
	</div>
	<div id="info" class="cardstyle">
	<span class="bigowner"><?php echo ($uid); ?></span></br>
	</div>

	<div id="blacklist" class="cardstyle">
		已经屏蔽的玩家名单
		<table class="table table-striped table-bordered">
		<?php if(is_array($blist)): foreach($blist as $key=>$i): ?><tr>
			<td><?php echo ($i["player"]); ?></td>
		</tr><?php endforeach; endif; ?>
		</table>
	</div>

	<div id="account" class="cardstyle">
		绑定wow账号
	</div>

	<div id="changepwd" class="cardstyle">
		修改密码
	</div>

	<div id="sys" class="cardstyle">
		<form action="http://wow.caihongxd.com/index.php/home/User/logout" method="post">
			<button id="logout" type="submit" class="btn btn-danger">注销此用户</button>
		</form>
	</div>
</body>
</html>