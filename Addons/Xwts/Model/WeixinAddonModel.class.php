<?php
        	
namespace Addons\Xwts\Model;
use Home\Model\WeixinModel;
        	
/**
 * Xwts的微信模型
 */
class WeixinAddonModel extends WeixinModel{
	function reply($dataArr, $keywordArr = array()) {
		$config = getAddonConfig ( 'Xwts' ); // 获取后台插件的配置参数

        $tmp1 = implode(',', $dataArr);
        $tmp2 = implode(',', $keywordArr);

        $article = array();
        for($i = 0; $i < $config['num']; $i++){
            $article[] = array(
                'Title'=>"$tmp2",
                'Description'=>"desc",
                'PicUrl'=>'http://www.baidu.com/img/bd_logo1.png',
                'Url'=>'http://baidu.com/'
            );
        }

		$this->replyNews($article);

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
        	