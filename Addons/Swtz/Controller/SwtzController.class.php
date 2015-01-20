<?php

namespace Addons\Swtz\Controller;
use Home\Controller\AddonsController;

class SwtzController extends AddonsController{
	public function center(){
		$map['token'] = get_token();
		$map['openid'] = get_openid();
		$user = M('swuser')->where($map)->find();
		if(!$user){
			$this->error("InValid");
		}

		$this->assign('aaa', 'sb');
		$this->display('center');
	}
}
