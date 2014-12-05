<?php

namespace Addons\UserCenter\Model;

use Home\Model\WeixinModel;

/**
 * UserCenter的微信模型
 */
class WeixinAddonModel extends WeixinModel {
	var $config = array ();
	function reply($dataArr, $keywordArr = array()) {
		$map ['token'] = get_token ();
		$keywordArr ['aim_id'] && $map ['id'] = $keywordArr ['aim_id'];
		//$data = M ( 'usercenter' )->where ( $map )->find ();
		// 其中token和openid这两个参数一定要传，否则程序不知道是哪个微信用户进入了系统
		$param ['token'] = get_token ();
		$param ['openid'] = get_openid ();
		$url = addons_url ( 'UserCenter://UserCenter/addBind', $param );

		$articles [0] = array (
				'Title' => $map ['token'],
				'Url' => $url
		);

		$this->replyNews ( $articles );
	}
	// 关注时的操作
	function subscribe($dataArr) {
		$info = D ( 'Common/Follow' )->init_follow ( $dataArr ['FromUserName'] );
		
		// 增加积分
		session ( 'mid', $info ['id'] );
		add_credit ( 'subscribe' );
	}
	// 取消关注公众号事件
	public function unsubscribe() {
		// 增加积分
		add_credit ( 'unsubscribe' );
	}
}
        	