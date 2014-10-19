<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<link rel="stylesheet" type="text/css" href="/Public/css/bmin.css" />
	<link rel="stylesheet" type="text/css" href="/Public/css/switch.css" />
	<script type="text/javascript" src="/Public/js/jquery.js"></script><script type="text/javascript" src="/Public/js/bmin.js"></script><script type="text/javascript" src="/Public/js/Chart.js"></script><script type="text/javascript" src="/Public/js/switch.js"></script>
	<link rel="stylesheet" type="text/css" href="/Public/css/mycss.css" />
	<title>Wow物价查询</title>
</head>
<body>
	<div class="nav">
		<div class = "subnav">
		<ol class="pull-left breadcrumb">
  			<li><a href="http://wow.caihongxd.com">拍卖行</a></li>
  			<li class="active"><?php echo ($name); ?></li>
  		</ol>
  		<?php if($uid == ''): ?><a class="pull-right btns" href="http://wow.caihongxd.com/index.php/home/User/login">登陆</a>
  		<?php else: ?>
  		  			<span class="pull-right btns">Hi,&nbsp<a href="http://wow.caihongxd.com/index.php/home/User/profile"><?php echo ($uid); ?></a>!</span><?php endif; ?>
  		</div>
	</div>
	<div id="header"></div>
	<div id="info" class="cardstyle">
	<img class="big_icon" src="http://content.battlenet.com.cn/wow/icons/56/<?php echo ($icon); ?>.jpg"></img>	
	 <a href="http://wow.caihongxd.com/index.php/home/Index/index.html?name=<?php echo ($name); ?>">
	<span class="title itemid quality_<?php echo ($quality); ?>"><?php echo ($name); ?></span></a></br>
	<a href="http://www.battlenet.com.cn/wow/zh/item/<?php echo ($itemid); ?>">http://www.battlenet.com.cn/wow/zh/item/<?php echo ($itemid); ?></a>
	</div>
	<div id="history" class="cardstyle">
	<canvas id = "Chart" width="700" height="300">
	</canvas>
	<div id="anch"></div>
	</div>

	<div id="content" class="cardstyle">
		<form role = "form" id = "formbox" action="http://wow.caihongxd.com/index.php/home/Index/item/itemid/<?php echo ($itemid); ?>.html#anch" method="post">
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
			<th>玩家</th>
			<th>数量</th>
			<th>价格</th>
			<th>屏蔽</th>
		</tr>

		<?php if(is_array($info)): foreach($info as $key=>$i): ?><tr>
			<td><?php echo ($i["day"]); ?></td>
			<td>
			<a href="http://wow.caihongxd.com/index.php/home/Index/user/userid/<?php echo ($i["owner"]); ?>">
			<span class="owner">
			<?php echo ($i["owner"]); ?>
			</span>
			</a>
			</td>
			<td><?php echo ($i["quantity"]); ?></td>
			<td class="text-right">
				<span class='gold'><?php echo ($i["avgg"]); ?></span>
				<span class='silver'><?php echo ($i["avgs"]); ?></span>
				<span class='copper'><?php echo ($i["avgc"]); ?></span>
			</td>
			<td>
				<?php if($uid == ''): else: ?>
				<input type="checkbox" name="<?php echo ($i["owner"]); ?>" class="blackbox" state="<?php echo ($i["exist"]); ?>">
				<?php if($i["danger"] == 1): ?><span><img src="http://wow.caihongxd.com/alert.png" width="20px" height="20px" /></span><?php endif; endif; ?>
			</td>
		</tr><?php endforeach; endif; ?>

		</table>
	</div>
	<script type="text/javascript">
		$("[class='blackbox']").bootstrapSwitch();
		$('input[class="blackbox"]').bootstrapSwitch('offText', "&nbsp");
		$('input[class="blackbox"]').bootstrapSwitch('onText', "已屏蔽");
		$('input[class="blackbox"]').bootstrapSwitch('onColor', "danger");
		$('input[state="black"]').bootstrapSwitch('state',true);
		/*$('input[type="checkbox"]').bootstrapSwitch('offText', "&nbsp");
		$('input[type="checkbox"]').bootstrapSwitch('onText', "已屏蔽");
		$('input[type="checkbox"]').bootstrapSwitch('onColor', "danger");
		$('input[class="blackbox black"]').bootstrapSwitch('state',true);*/

		$('input[class="blackbox"]').on('switchChange.bootstrapSwitch', function(event, state) {
  			console.log(this.name); // DOM element
  			console.log(event); // jQuery event
  			console.log(state); // true | false
  			$.ajax({
				type:"post",
				url:"http://wow.caihongxd.com/index.php/home/User/defriend",
				dataType:"JSONP",
				data:{
				"name":this.name,
				"state":state
				},
				success:function(data)
				{
					//refresh;
				},

			});
		});

		var ctx = $("#Chart").get(0).getContext("2d");
		//This will get the first returned node in the jQuery collection.
		var myNewChart = new Chart(ctx);
		
		var data = {
			labels : ["<?php echo ($labels["1"]); ?>","<?php echo ($labels["2"]); ?>","<?php echo ($labels["3"]); ?>","<?php echo ($labels["4"]); ?>","<?php echo ($labels["5"]); ?>","<?php echo ($labels["6"]); ?>","<?php echo ($labels["7"]); ?>"],
			datasets : [{
				fillColor : "rgba(151,187,205,0.5)",
				strokeColor : "rgba(151,187,205,1)",
				pointColor : "rgba(151,187,205,1)",
				pointStrokeColor : "#fff",
				data : [<?php echo ($datas["1"]); ?>,<?php echo ($datas["2"]); ?>,<?php echo ($datas["3"]); ?>,<?php echo ($datas["4"]); ?>,<?php echo ($datas["5"]); ?>,<?php echo ($datas["6"]); ?>,<?php echo ($datas["7"]); ?>]
			}]
		}

		new Chart(ctx).Line(data);
	</script>
</body>