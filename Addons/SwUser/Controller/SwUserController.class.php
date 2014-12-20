<?php

namespace Addons\SwUser\Controller;
use Home\Controller\AddonsController;

class SwUserController extends AddonsController{
    /**
     * 后台显示微信用户列表数据
     */
    public function lists() {
        $this->assign ( 'add_button', true );
        $this->assign ( 'del_button', true );
        $this->assign ( 'check_all', false );

        $model = $this->getModel ( 'swuser' );

        parent::common_lists ( $model );
    }

    /**
     * display 增加绑定页面
     */
    public function addBind(){
        $params['token'] = get_token();
        $params['openid'] = get_openid();
        if(!$params['token'] || !$params['openid']){
            return $this->error ( '非法操作！');
        }

        $user = M( 'swuser' )->where($params)->find();
        if($user['user_state']){
            $url = addons_url ( 'SwUser://SwUser/center' );
            return $this->error( '您已经绑定过了! 现在跳转到用户中心.' , $url, 3);
        }
        $this->assign("data", $params);
        $this->display( 'addBind' );
    }

    /**
     * POST 接收绑定验证并跳转
     */
    public function postBind(){
        $token = I('post.token');
        $openid = I('post.openid');
        if(!$token || !$openid){
            $this->error ( ' 非法操作！');
        }

        $params['user_type'] = I('post.utype') ? 1 : 0;
        $params['school_id'] = I('post.sid');
        $userPwd = I('post.pwd');

        $_model = M( 'swuser' );
        $user = $_model->where($params)->find();
        if($user['user_birth'] == $userPwd){
            $map = $params;
            $map['token'] = $token;
            $map['openid'] = $openid;
            $map['user_state'] = 1;
            $_model->where($params)->save($map);
            $url = addons_url( 'SwUser://SwUser/center' );
            return $this->success( '绑定成功! 现在跳转到用户中心.' , $url, 3);
        }else{
            $this->error ( ' 验证失败, 请检查您输入信息的正误, 或联系客服处理. ' );
        }

    }

    /**
     * display 用户状态页面
     */
    public function center(){
        $params['token'] = get_token();
        $params['openid'] = get_openid();
        $user = M('swuser')->where($params)->find();
        if($user['user_state'] == 0){
            $url = addons_url( 'SwUser://SwUser/addBind' );
            return $this->error ( ' 未绑定, 请先绑定账号! ', $url, 2);
        }

        $url['unbind'] = addons_url('SwUser://SwUser/unBind');
        $this->assign('url', $url);
        $this->assign('user', $user);

        $this->display('center');
    }

    /**
     * 解除绑定
     */
    public function unBind(){
        $map['token'] = get_token();
        $map['openid'] = get_openid();
        if(!$map['token'] || !$map['openid']){
            $this->error ( ' 非法操作！');
        }
        $_model = M('swuser');
        $user = $_model->where($map)->find();
        if($user){
            $unbind = $user;
            $unbind['token'] = NULL;
            $unbind['openid'] = NULL;
            $unbind['user_state'] = 0;
            $_model->where($map)->save($unbind);
            $this->success('解除绑定成功!');
        }else{
            $this->error ( ' 非法操作！');
        }
    }

}

