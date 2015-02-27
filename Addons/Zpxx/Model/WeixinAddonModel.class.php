<?php
        	
namespace Addons\Zpxx\Model;
use Home\Model\WeixinModel;
        	
/**
 * Zpxx的微信模型
 */
class WeixinAddonModel extends WeixinModel{
	function reply($dataArr, $keywordArr = array()) {
		$config = getAddonConfig ( 'Zpxx' ); // 获取后台插件的配置参数	
		//dump($config);
        $num = $config['num'];
        $data = M('zpxx')->order('id desc')->limit($num)->select();
        $result = array();
        foreach ($data as $item) {
            $result[] = "{$item['time']} : \n<a href=\"{$item['url']}\">{$item['title']}</a>";
        }

        $text = implode("\n\n", $result);
        $this->replyText($text);

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
        	