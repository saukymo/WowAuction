<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<link rel="stylesheet" type="text/css" href="/Public/css/bmin.css" />
	<script type="text/javascript" src="/Public/js/jquery.js"></script><script type="text/javascript" src="/Public/js/bmin.js"></script>
	<link rel="stylesheet" type="text/css" href="/Public/css/mycss.css" />
	<title>Wow物价查询</title>
</head>
<body>
	<?php
 ?>
	<!--<script type="text/javascript">
		$(document).ready(function()
		{
			//$("#header").fadeOut(3000);
			$("#header").slideToggle(3000);
		})
	</script> -->
	<div class="nav">
		<div class = "subnav">
		<ol class="pull-left breadcrumb">
  			<li class="active">拍卖行</li>
  		</ol>
  		<?php if($uid == ''): ?><a class="pull-right btns" href="http://wow.caihongxd.com/index.php/home/User/login">登陆</a>
  		<?php else: ?>
  		  			<span class="pull-right btns">Hi,&nbsp<a href="http://wow.caihongxd.com/index.php/home/User/profile"><?php echo ($uid); ?></a>!</span><?php endif; ?>
  		</div>
	</div>
	<!--<div id="header" class="cardstyle">
		<img src="http://wow.caihongxd.com/banner.png">
	</div>-->
	<div id="content" class="cardstyle">
	<form role = "form" id = "formbox" action="http://wow.caihongxd.com/index.php/home/Index/index/page/1.html" method="get">
		<div class = "form-group pull-left">
		<label>物品名称</label>
		<input type="text" class="form-control" name="name" value="<?php echo ($name); ?>">
		</div>
		<div class = "form-group pull-left">
		<label>类别</label>
		<select class="form-control" id="class" name = "itemclass"> 
			<option value="0">全部</option>
			<option value="4">武器</option>
			<option value="6">护甲</option>
			<option value="3">容器</option>
			<option value="2">消耗品</option>
			<option value="18">雕文</option>
			<option value="9">商品</option>
			<option value="11">配方</option>
			<option value="5">珠宝</option>
			<option value="17">其它</option>
			<option value="14">任务</option>
			<option value="19">战斗宠物</option>
		</select>
		</div>
		<div class = "form-group pull-left">
		<label>稀有程度</label>
		<select class="form-control" name = "quality">
			<option value="0">全部</option>
			<option value="1">普通</option>
			<option value="2">优秀</option>
			<option value="3">精良</option>
			<option value="4">史诗</option>
		</select>
		</div>
		<div class = "form-group pull-left">
		<label>&nbsp</label>
		<button type = "submit" class = "form-control btn btn-default">浏览</button>
		</div>
	</form>
	<table class="table table-striped table-bordered">
		<tr>
			<th>名称</th>
			<th>数量</th>
			<th>价格</th>
		</tr>
		<?php if(is_array($items)): foreach($items as $key=>$i): ?><tr>
			<td>
				<img class = "icon" src="http://content.battlenet.com.cn/wow/icons/36/<?php echo ($i["icon"]); ?>.jpg"></img>
				<a href = "http://wow.caihongxd.com/index.php/home/Index/item/itemid/<?php echo ($i["item"]); ?>">
				<span class="itemid quality_<?php echo ($i["quality"]); ?>"><?php echo ($i["name"]); ?></span></br>
				</a>
				<a href="http://wow.caihongxd.com/index.php/home/Index/user/userid/<?php echo ($i["owner"]); ?>">
				<span class="owner"><?php echo ($i["owner"]); ?></span>
				</a>
			</td>
			<td><?php echo ($i["quantity"]); ?></td>
			<td class="text-right">
				<p>
				<span class='gold'><?php echo ($i["bidg"]); ?></span>
				<span class='silver'><?php echo ($i["bids"]); ?></span>
				<span class='copper'><?php echo ($i["bidc"]); ?></span>
				</p>
				<p>
				<span class='gold'><?php echo ($i["buyg"]); ?></span>
				<span class='silver'><?php echo ($i["buys"]); ?></span>
				<span class='copper'><?php echo ($i["buyc"]); ?></span>
				</p>
			</td>
		</tr><?php endforeach; endif; ?>
	</table>
	<div>
	<div class="pull-left"> 当前显示第<span class="pagenumber"><?php echo ($startIndex); ?></span>-第<span class="pagenumber"><?php echo ($endIndex); ?></span>条结果（共<span class="pagenumber"><?php echo ($itemCount); ?></span>条结果）</div>
	<div class="btn-group pull-right"><a type="button" class="btn btn-default btn-sm" href="http://wow.caihongxd.com/index.php/home/Index/index/page/<?php echo ($pageNow - 1); ?>.html?name=<?php echo ($name); ?>&itemclass=<?php echo ($itemclass); ?>&quality=<?php echo ($quality); ?>">上一页</a><button type="button" class="btn btn-default btn-sm disabled"><?php echo ($pageNow); ?></button><a type="button" class="btn btn-default btn-sm" href="http://wow.caihongxd.com/index.php/home/Index/index/page/<?php echo ($pageNow + 1); ?>.html?name=<?php echo ($name); ?>&itemclass=<?php echo ($itemclass); ?>&quality=<?php echo ($quality); ?>">下一页</a></div>
	</div>
	<script>
		document.getElementById("class").value="<?php echo ($itemclass); ?>";
	</script>

</body>
</html>