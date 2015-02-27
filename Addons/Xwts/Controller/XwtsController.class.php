<?php

namespace Addons\Xwts\Controller;
use Home\Controller\AddonsController;

class XwtsController extends AddonsController{
//    var $config;
//    function _initialize() {
//        parent::_initialize();
//
//        $controller = strtolower ( _CONTROLLER );
//
//        $res ['title'] = '新闻推送';
//        $res ['url'] = addons_url ( 'CustomReply://CustomReply/lists' );
//        $res ['class'] = $controller == 'customreply' ? 'current' : '';
//        $nav [] = $res;
//
//        $this->assign ( 'nav', $nav );
//
//        $config = getAddonConfig ( 'CustomReply' );
//        $config ['cover_url'] = get_cover_url ( $config ['cover'] );
//        $this->config = $config;
//        $this->assign ( 'config', $config );
//        // dump ( $config );
//        // dump(get_token());
//    }
    public function center(){
        $map['token'] = get_token();
        $map['openid'] = get_openid();
        $user = M('swuser')->where($map)->find();
        if(!$user){
            $this->error("用户非法!");
        }

        $mapTz ['id'] = I ( 'get.id', 0, 'intval' );
        $info = M ( 'xwts' )->where ( $mapTz )->find ();

        if($user['user_type'] == 0){ //学生
            if($info['type'] != 0){
                $this->error("用户非法!");
            }
        }elseif($user['user_type'] == 1){ //老师
            if($info['type'] != 1){
                $this->error("用户非法!");
            }
        }

        $this->assign ( 'info', $info );

        $this->display('center');
    }
}
