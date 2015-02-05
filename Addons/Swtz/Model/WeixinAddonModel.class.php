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
        $user = M('swuser')->where($map)->find();
        if(!$user){
            $this->replyText('请先绑定账户!');
        }
		$_model = M('swtz');
		$arts = $_model->limit($num)->order('id desc')->select();
        foreach($arts as $k => $v) {
            if($v['type'] != $user['user_type']) continue;
            $params = $map;
            $params [ 'id' ] = $v [ 'id' ];
            $url = addons_url ( 'Swtz://Swtz/center', $params);
            $articles [$k] = array (
                'Title' => $v['title'],
                'Description' => $v['intro'],
                'Url' => $url
            );
        }
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
        	