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
  			<li class="active"><?php echo ($userid); ?></li>
  		</ol>
  		<?php if($uid == ''): ?><a class="pull-right btns" href="http://wow.caihongxd.com/index.php/home/User/login">登陆</a>
  		<?php else: ?>
  		  			<span class="pull-right btns">Hi,&nbsp<a href="http://wow.caihongxd.com/index.php/home/User/profile"><?php echo ($uid); ?></a>!</span><?php endif; ?>
  		</div>
	</div>
	<div id="info" class="cardstyle">
	<?php if($found == 0): ?><p>
	<span class="bigowner"><?php echo ($userid); ?></span></br>
	</p>
	<p>
	<span class="alert">该角色不存在或等级未超过10级</span>
	</p>
	<?php else: ?>
	<img class="big_icon" src="http://www.battlenet.com.cn/static-render/cn/<?php echo ($thumbnail); ?>"></img>	
	<span class="bigowner"><?php echo ($userid); ?></span></br>
	<p class="color-c<?php echo ($classno); ?>">
	<strong><span><?php echo ($level); ?></span>
	<span><?php echo ($race); ?></span>
	<span><?php echo ($classes); ?></span>
	</strong>
	</p><?php endif; ?>
	<div id="anch"></div>
	</div>

	<div id="content" class="cardstyle">
		<form role = "form" id = "formbox" action="http://wow.caihongxd.com/index.php/home/Index/user/userid/<?php echo ($userid); ?>.html#anch" method="post">
			<div class = "form-group pull-right">
				<button type = "submit" class = "form-control btn btn-default">查看</button>
			</div>
			
			<div class = "form-group pull-right">
			<select class="form-control" id="day" name = "day" selected="<?php echo ($day); ?>"> 
				<?php if(is_array($labels)): foreach($labels as $key=>$label): if($day == $label): ?><option value="<?php echo ($label); ?>"
					selected="selected"><?php echo ($label); ?></option>
					<?php else: ?>
					<option value="<?php echo ($label); ?>"><?php echo ($label); ?></option><?php endif; endforeach; endif; ?>
			</select>
			</div>	
		</form>

		<table class="table table-striped table-bordered">
		<tr>
			<th>日期</th>
			<th>物品</th>
			<th>数量</th>
			<th>价格</th>
		</tr>

		<?php if(is_array($info)): foreach($info as $key=>$i): ?><tr>
			<td><?php echo ($i["day"]); ?></td>
			<td>
			<a href="http://wow.caihongxd.com/index.php/home/Index/item/itemid/<?php echo ($i["item"]); ?>"><span class="itemid quality_<?php echo ($i["quality"]); ?>"><?php echo ($i["name"]); ?></span></a>
			</td>
			<td><?php echo ($i["quantity"]); ?></td>
			<td class="text-right">
				<span class='gold'><?php echo ($i["avgg"]); ?></span>
				<span class='silver'><?php echo ($i["avgs"]); ?></span>
				<span class='copper'><?php echo ($i["avgc"]); ?></span>
			</td>
		</tr><?php endforeach; endif; ?>

		</table>
	</div>
</body>
</html>