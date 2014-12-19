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
        $map['openid'] = get_openid();
        $map['token'] = get_token();
        $user = M('swuser')->where($map)->find();
        if(!$user || !$user['user_state']){
            $url = addons_url('SwUser://SwUser/addBind');
            return $this->error('请先绑定账户!', $url, 2);
        }
        $_model = M('xytl');
        $data = $_model->order('od')->select();
        $res = array();
        foreach ($data as $v) {
            $res[$v['type']][] = $v;
        }
        $this->assign('data', $res);
        $this->display('center');
    }
}
