<?php

namespace Addons\Swtz\Controller;
use Home\Controller\AddonsController;

class SwtzController extends AddonsController{

	public function center(){
		$map['token'] = get_token();
		$map['openid'] = get_openid();
		$user = M('swuser')->where($map)->find();
		if(!$user){
			$this->error("用户非法!");
		}

        $mapTz ['id'] = I ( 'get.id', 0, 'intval' );
        $info = M ( 'swtz' )->where ( $mapTz )->find ();

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
