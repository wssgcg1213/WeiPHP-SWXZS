<?php
        	
namespace Addons\SwUser\Model;
use Home\Model\WeixinModel;
        	
/**
 * SwUser的微信模型
 */
class WeixinAddonModel extends WeixinModel{
	function reply($dataArr, $keywordArr = array()) {
		$config = getAddonConfig ( 'SwUser' ); // 获取后台插件的配置参数	
		//dump($config);
        $param ['token'] = get_token ();
        $param ['openid'] = get_openid ();
        $user = M('swuser')->where($params)->find();
        $url = addons_url ( 'SwUser://SwUser/addBind', $param );
        if($user){
            $replyText = json_encode($user)."<a href='$url'>URL</a>";
        }else{
            $replyText = json_encode($user)."<a href='$url'>URL</a>";
        }
        $this->replyText($replyText);
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
        	