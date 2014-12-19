<?php
        	
namespace Addons\Xytl\Model;
use Home\Model\WeixinModel;
        	
/**
 * Xytl的微信模型
 */
class WeixinAddonModel extends WeixinModel{
	function reply($dataArr, $keywordArr = array()) {
		//$config = getAddonConfig ( 'Xytl' ); // 获取后台插件的配置参数
		//dump($config);
        $openid = get_openid();
        $token = get_token();
//        if(!isBindSwUser($openid, $token)){
//            return $this->replyText("请先回复绑定并绑定真实信息以使用本功能.");
//        }
        $url = addons_url ( 'Xytl://Xytl/center' );
        $articles [0] = array (
            'Title' => '学院通联',
            'Description' => '学院各办公室, 学生会以及各班班长、团支书的联系电话及邮箱{$openid},{$token}',
            //'PicUrl' => '',
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
        	