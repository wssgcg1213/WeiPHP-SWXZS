<?php

namespace Addons\Xytl\Controller;
use Home\Controller\AddonsController;

class XytlController extends AddonsController{
    public function lists(){
        $this->assign ( 'add_button', true );
        $this->assign ( 'del_button', true );
        $this->assign ( 'check_all', false );

        $model = $this->getModel ( 'xytl' );

        parent::common_lists ( $model );
    }

    /**
     * center
     */
    public function center(){
        $_model = M('xytl');

        $data = M('xytl')->order('od DESC')->select();
        $res = array();
        foreach ($data as $v) {
            $res[$v['type']][] = $v;
        }
        echo json_encode($res);
    }
}
