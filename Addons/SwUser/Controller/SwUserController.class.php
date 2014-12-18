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

        $this->display( 'addBind' );
    }

    /**
     * POST 接收绑定验证并跳转
     */
    public function postBind(){
        $token = get_token();
        $openid = get_openid();
        if(!$token || !$openid){
            $this->error ( ' 非法操作！');
        }

        $params['user_type'] = I('post.utype') ? 1 : 0;
        $params['school_id'] = I('post.sid');
        $params['user_birth'] = I('post.pwd');

        $_model = M( 'swuser' );
        $user = $_model->where($params)->find();
        if($user){
            $map = $params;
            $map['token'] = $token;
            $map['openid'] = $openid;
            $map['user_state'] = 1;
            $_model->where($params)->save($map);
            $url = addons_url( 'SwUser://SwUser/center' );
            return $this->error( '您已经成功绑定! 现在跳转到用户中心.' , $url, 3);
        }
        $this->error ( ' 绑定失败, 请检查输入或者联系客服处理. ' );
    }

    /**
     * display 用户状态页面
     */
    public function center(){
        $params['token'] = get_token();
        $params['openid'] = get_openid();
        $user = M('swuser')->where($params)->find();
        if($user['user_state'] == 0){
            $url = $url = addons_url( 'SwUser://SwUser/addBind' );
            return $this->error ( ' 未绑定, 请先绑定账号! ' );
        }

        $this->assign('user', $user);

        $this->display();
    }

}

