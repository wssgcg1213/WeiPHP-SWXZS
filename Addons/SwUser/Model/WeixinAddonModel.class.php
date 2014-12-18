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

        if($user['user_state']){
            $url = addons_url ( 'SwUser://SwUser/center', $param );
            $replyText = $user['real_name'].", 你已经绑定过了哦! <a href='$url'>点击进入</a>用户中心.";
        }else{
            $url = addons_url ( 'SwUser://SwUser/addBind', $param );
            $replyText = "你还没有绑定校园账号噢, 为了方便使用大部分功能, 请先<a href='$url'>点我绑定</a>.";
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
        	