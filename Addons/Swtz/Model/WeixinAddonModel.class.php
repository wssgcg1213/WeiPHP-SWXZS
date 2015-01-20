<?php
        	
namespace Addons\Swtz\Model;
use Home\Model\WeixinModel;
        	
/**
 * Swtz的微信模型
 */
class WeixinAddonModel extends WeixinModel{
	function reply($dataArr, $keywordArr = array()) {
		$config = getAddonConfig ( 'Swtz' ); // 获取后台插件的配置参数
		$num = $config['num'];
		$map['token'] = get_token();
		$map['openid'] = get_openid();
		
		$_model = M('swtz');

		$arts = $_model->limit($num)->select();

		$url = addons_url ( 'Swtz://Swtz/center' , $map);
		$articles [0] = $articles [1] = array (
				'Title' => $arts[0]['title'],
				'Description' => $arts[0]['content'],
				'Url' => $url 
		);
		$this->replyNews($articles);

	} 

	// 关注公众号事件
	public function subscribe() {
		return true;
	}
	
	// 取消关注公众号事件
	public function unsubscribe() {
		return true;
	}
	
	// 扫描带参数二维码事件
	public function scan() {
		return true;
	}
	
	// 上报地理位置事件
	public function location() {
		return true;
	}
	
	// 自定义菜单事件
	public function click() {
		return true;
	}	
}
        	