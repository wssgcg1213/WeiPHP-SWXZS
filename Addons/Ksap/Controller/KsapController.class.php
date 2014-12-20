<?php

namespace Addons\Ksap\Controller;
use Home\Controller\AddonsController;

class KsapController extends AddonsController{
    public function center(){
        $map['openid'] = get_openid();
        $map['token'] = get_token();
        $user = M('swuser')->where($map)->find();
        if(!$user || !$user['user_state']){
            $url = addons_url('SwUser://SwUser/addBind');
            return $this->error('请先绑定账户!', $url, 2);
        }

        if($user['user_type'] == 1){
            $userCenter = addons_url('SwUser://SwUser/center');
            $this->error('老师没有考试的.', $userCenter, 3);
        }else{
            $config = getAddonConfig ( 'Ksap' );
            $data = M('ksap')->where(array('school_id' => $user['school_id'], 'term' => $config['term']))->select();
            $res = array();
            foreach ($data as $v) {
                $res[$v['term']][] = $v;
            }
            $this->assign('user', $user['real_name']);
            $this->assign('data', $res);
            $this->display('center');
        }

    }
}
