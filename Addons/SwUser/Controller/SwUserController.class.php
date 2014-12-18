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

        $this->display( 'addBind' );

    }

    /**
     * POST 接收绑定验证并跳转
     */
    public function postBind(){

    }

    /**
     * display 用户状态页面
     */
    public function center(){

    }

}

