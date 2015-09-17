<?php

namespace Addons\xysd\Controller;
use Home\Controller\AddonsController;

class xysdController extends AddonsController{
    public function index(){
        $map['openid'] = get_openid();
        if(!$map['openid']){
            return $this->error("非法访问! 请从微信端进入!");
        }
        $this->assign("openid", $map['openid']);

        $nicknameRow = M('xysduser')->where($map)->find();
        if(!$nicknameRow){
            return $this->display("nickname");
        }

        $data = M('xysd')->order("cTime desc")->where(array(
            "status" => "1"
        ))->select();

        $this->assign("data", $data);
        $this->display();
    }

    public function verify(){
        $openid = I('post.openid');
        $nickname = I('post.nickname');
        if(!trim($nickname) || !$openid){
            return $this->error("非法的昵称!");
        }

        $repeat = M('xysduser')->where(array("nickname"=>$nickname))->find();
        if($repeat){
            return $this->error("已经有人用了这个昵称了!");
        }

        $record['nickname'] = $nickname;
        $record['openid'] = $openid;
        M('xysduser')->add($record);
        $this->success("成功! ".$nickname." , 正在进入!", addons_url("xysd://xysd/index", array(
            "openid" => $openid
        )));
    }
}
