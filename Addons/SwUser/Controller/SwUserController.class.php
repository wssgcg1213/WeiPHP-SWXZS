<?php

namespace Addons\SwUser\Controller;
use Home\Controller\AddonsController;

class SwUserController extends AddonsController{
    /**
     * 显示微信用户列表数据
     */
    public function lists() {
        $this->assign ( 'add_button', true );
        $this->assign ( 'del_button', true );
        $this->assign ( 'check_all', false );

        $model = $this->getModel ( 'swser' );

        parent::common_lists ( $model );
    }
}
