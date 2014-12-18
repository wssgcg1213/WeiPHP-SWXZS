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

        $model = $this->getModel ( 'swser' );

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
        if($user){
            $url = addons_url ( 'SwUser://SwUser/center' );
            return $this->error( '您已经绑定过了! 现在跳转到用户中心.' , $url, 3);
        }
        $this->display( 'addBind' );

    }

    /**
     * POST 接收绑定验证并跳转
     */
    public function postBind(){
        $params['token'] = get_token();
        $params['openid'] = get_openid();
        if(!$params['token'] || !$params['openid']){
            $this->error ( ' 非法操作！');
        }
    }

    /**
     * display 用户状态页面
     */
    public function center(){
        $this->display();
    }

}

