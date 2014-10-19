<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {

    public function login()
    {
        $this->uid = cookie('uid');
        $this->show();        
    }

    public function check()
    {
        $user = M("user");
        $usr = I('post.usr');
        $pwd = I('post.pwd');
        $condition = array("user" => $usr);
        $rst = $user->where($condition)->select();
        if (count($rst) == 0)
        {
            $data["info"] = "用户名不存在！";
            $data["type"] = 1;
        }
        else
        {
            $condition = array("user" => $usr, "pwd" => $pwd);
            $rst = $user->where($condition)->select();
            if (count($rst) != 0)
            {
                $data["info"] = "登陆成功";
                $data["type"] = 0;
                cookie('uid', $usr);
            }   
            else
            {
                $data["info"] = "密码错误";
                $data["type"] = 1;
            }
        }
        $cb = I("get.callback");
        echo $cb."(".json_encode($data).")";
    }

    public function register()
    {
        $this->uid = cookie('uid');
        $this->show();
    }

    public function regcheck()
    {
        $user = M("user");
        $usr = I('post.usr');
        $pwd = I('post.pwd'); 
        $cpwd = I('post.cpwd');
        $condition = array("user" => $usr);
        $rst = $user->where($condition)->select();
        if ($rst > 0)
        {
            $data["info"] = "用户名已存在！";
            $data["type"] = 1;
        }
        else
        {
            if ($pwd == $cpwd)
            {
                $new = array();
                $new["user"] = $usr;
                $new["pwd"] = $pwd;
                $new["priv"] = 0;
                $user->add($new);
                $data["info"] = "注册成功！3s后跳转到登陆界面..";
                $data["type"] = 0;
            }
            else
            {
                $data["info"] = "两次密码输入不一致！";
                $data["type"] = 1;
            }
        }
        $cb = I("get.callback");
        echo $cb."(".json_encode($data).")";
    }

    public function logout()
    {
        cookie("uid", null);
        $this->redirect("http://wow.caihongxd.com/", "", 0);
    }

    public function profile()
    {
        $this->uid = cookie('uid');
        $blacklist = M('blacklist');

        $condition = array();
        $condition["user"] = $this->uid;
        $this->blist = $blacklist->where($condition)->select();
        $this->show();
    }

    public function defriend()
    {
        $uid = cookie("uid");
        $player = I("post.name");
        $state = I("post.state");
        $blacklist = M("blacklist");
        if ($state == "true")
        {
            $data["user"] = $uid;
            $data["player"] = $player;
            $blacklist->add($data);
            $data = "T";
        }
        else
        {
            $data["user"] = $uid;
            $data["player"] = $player;
            $blacklist->where($data)->delete();
            $data = "F";
        }
        $cb = I("get.callback");
        echo $cb."(".json_encode($data).")";
    }
}
