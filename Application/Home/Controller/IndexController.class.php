<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    public function index(){
    	$this->pageNow = I('get.page');
    	$this->name = I('get.name');
    	$this->itemclass = I('get.itemclass');
    	$this->quality = I('get.quality');
        $this->uid = cookie('uid');
    	if (empty($this->itemclass))
    		$this->itemclass = "0";
    	if (empty($this->quality))
    		$this->quality = "0";
    	$this->pageSize = 20;
		$info = M('auction');
		$item = M('iteminfo');

		$this->time = $info -> max("time");
		$condition['time'] = array('egt', $this->time);
		$condition['group'] = array('eq', 1); 
		if ($this->name)
			$condition['name'] = array('like', '%'.$this->name.'%' );
		if ($this->itemclass != 0)
			$condition['class'] = array('eq', $this->itemclass - 2);
		if ($this->quality != 0)
			$condition['quality'] = array('eq', $this->quality);
		$auc = $info -> where($condition)->order('item')->limit(400)->select();
		$total = count($auc);
		$items = array();
		for ($i = 0; $i < $total; $i++)
		{
			$rst = $item -> where('item='.$auc[$i]['item']) -> select();
			if (count($rst) != 0)
			{
				$new['name'] = $rst[0]["name"];
				$new['icon'] = $rst[0]["icon"];
				$new['quality'] = $rst[0]["quality"];
				$new['owner'] = $auc[$i]['owner'];
				$new['item'] = $auc[$i]['item'];
				$new['quantity'] = $auc[$i]['quantity'];
				$new['bidg'] = (int)substr($auc[$i]['bid'], 0, strlen($auc[$i]['bid']) - 4);
				$new['bids'] = (int)substr($auc[$i]['bid'], -4, 2);
				$new['bidc'] = (int)substr($auc[$i]['bid'], -2, 2);
				$new['buyg'] = (int)substr($auc[$i]['buyout'], -6, strlen($auc[$i]['buyout']) - 4);
				$new['buys'] = (int)substr($auc[$i]['buyout'], -4, 2);
				$new['buyc'] = (int)substr($auc[$i]['buyout'], -2, 2);				
				$items[] = $new;
			}
		}
		$this->itemCount = count($items);
		$this->allitem = $items;
		if ($this->itemCount % $this->pageSize == 0)
			$this->pageCount = (int)($this->itemCount / $this->pageSize);
		else
			$this->pageCount = (int)($this->itemCount / $this->pageSize + 1);

		if ($this->pageNow < 1)
    		$this->pageNow = 1;
    	if ($this->pageNow > $this->pageCount)
    		$this->pageNow = $this->pageCount;

    	$this->startIndex = ($this->pageNow - 1) * $this->pageSize;
    	$this->endIndex = $this->startIndex + $this->pageSize;

    	if($this->startIndex < 0)
    		$this->startIndex = 0;
    	if ($this->endIndex > $this->itemCount)
    		$this->endIndex = $this->itemCount;

    	$this->items = array_slice($this->allitem, $this->startIndex, $this->pageSize);
    	$this->show();
    }

    public function item()
    {
    	$this->itemid = I("get.itemid");
        $this->day = I("post.day");
    	$trade = M('tradeinfo');
    	$itemattr = M('iteminfo');
        $this->uid = cookie('uid');
    	$time = time();
    	//echo date('y-m-d', $time);
    	$datas = array();
    	$axis = array();

        $blacklist = M('blacklist');
        $condition = array();
        $condition["user"] = $this->uid;
        $blist = $blacklist->where($condition)->select();
        //print_r($blist);

        if ($this->day == 0)
        {
            $tmp = $time - 24 * 60 * 60;
            $this->day = date('y-m-d', $tmp);
        }

    	for ($i = 0; $i < 7; $i++)
    	{
    		$time -= 24 * 60 * 60;
    		$day = date('y-m-d', $time);
    		$condition = array();
    		$condition["day"] = $day;
    		$condition["item"] = $this->itemid;
    		$daytrade = $trade->where($condition)->select();
    		$sum = 0;
    		$num = 0;
    		//echo $day." ".count($daytrade)."</br>";
    		for ($j = 0; $j < count($daytrade); $j++)
    		{
                $exist = false;
                for ($k = 0; $k < count($blist); $k++)
                {
                    if ($blist[$k]["player"] == $daytrade[$j]["owner"])
                        $exist = true;
                }
                if ($exist) continue;

    			$sum += $daytrade[$j]["avg"] / 10000 * $daytrade[$j]["quantity"];
    			$num += $daytrade[$j]["quantity"];
    		}
    		if ($num != 0)
    		{
    			$datas[7 - $i] = floor($sum / $num * 100) / 100;
    		}
    		else
    		{
    			$datas[7 - $i] = 0;
    		}
            if ($day == $this->day)
            {
                $allavg = $datas[7 - $i];
            }

    		$axis[7 - $i] = $day;
    	}

    	$this->datas = $datas;
    	$this->labels = $axis;
    	

        $condition = array();
        $condition["day"] = $this->day;
        $condition["item"] = $this->itemid;
   		$info = $trade->where($condition)->select();

   		for ($i = 0; $i < count($info); $i++)
   		{
            $exist = false;
            for ($k = 0; $k < count($blist); $k++)
            {
                if ($blist[$k]["player"] == $info[$i]["owner"])
                    $exist = true;
            }
            if ($exist) 
            {
                $info[$i]["exist"] = "black";
            }
            else
            {
                $info[$i]["exist"] = "white";
            }
            if (($info[$i]["avg"] / 10000 > 3 * $allavg) and (!$exist)) 
            {
                $info[$i]["danger"] = 1;
            }
            else
            {
                $info[$i]["danger"] = 0;
            }

   			$info[$i]["avgg"] = floor($info[$i]["avg"] / 10000);
   			$info[$i]["avgs"] = floor($info[$i]["avg"] / 100) % 100;
   			$info[$i]["avgc"] = $info[$i]["avg"] % 100;
   		}
   		$this->info = $info;
        $condition = array("item" => $this->itemid);
   		$iteminfo = $itemattr->where($condition)->select();
   		$this->icon = $iteminfo[0]["icon"];
   		$this->quality = $iteminfo[0]["quality"];
   		$this->name = $iteminfo[0]["name"];
    	$this->show();
    }

    public function user()
    {
    	$this->userid = I("get.userid");
        $this->day = I("post.day");
    	$trade = M("tradeinfo");
        $races = M("race");
        $cls = M("classes");
    	$iteminfo = M("iteminfo");
        $this->uid = cookie('uid');

        $userinfo = M("userinfo");
        $condition = array();
        $condition["name"] = $this->userid; 
        $rst = $userinfo->where($condition)->select();

        $this->found = count($rst);
        if ($this->found > 0)
        {
            $race = $rst[0]["race"];
            $this->level = $rst[0]["level"];
            $classes = $rst[0]["class"];
            $this->thumbnail = $rst[0]["thumbnail"];
            $this->realm = $rst[0]["realm"];
            $this->gender = $rst[0]["gender"];

            $condition = array("index" => $race);
            $rst = $races->where($condition)->select();
            $this->race = $rst[0]["name"];

            $condition = array("index" => $classes);
            $rst = $cls->where($condition)->select();
            $this->classes = $rst[0]["name"];

            $this->classno = $classes;
        }



        $time = time();
        for ($i = 0; $i < 7; $i++)
        {
            $time -= 24 * 60 * 60;
            $day = date('y-m-d', $time);
            $axis[7 - $i] = $day;
        }
        $this->labels = $axis;

        if ($this->day == 0)
        {
            $this->day = $axis[7];
        }

    	$condition = array();
        $condition["day"] = $this->day;
    	$condition["owner"] = $this->userid;
    	$info = $trade->where($condition)->select();

    	for ($i = 0; $i < count($info); $i++)
    	{
    		$condition = array("item"=>$info[$i]["item"]);
    		$rst = $iteminfo->where($condition)->select();
    		$info[$i]["quality"] = $rst[0]["quality"];
    		$info[$i]["avgg"] = floor($info[$i]["avg"] / 10000);
   			$info[$i]["avgs"] = floor($info[$i]["avg"] / 100) % 100;
   			$info[$i]["avgc"] = $info[$i]["avg"] % 100;
    	}
    	$this->info = $info;
    	$this->show();
    }
}
