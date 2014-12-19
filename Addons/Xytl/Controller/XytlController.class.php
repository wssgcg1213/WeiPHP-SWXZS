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
        $types = $_model->field('type')->group('type')->select();
        $data = M('xytl')->order('order desc')->select();
        foreach($types as $item){
            foreach($data as $i){
                if($i['type'] == $item['type']){
                    array_push($item, $i);
                }
            }
        }
        echo json_encode($types);
    }
}
