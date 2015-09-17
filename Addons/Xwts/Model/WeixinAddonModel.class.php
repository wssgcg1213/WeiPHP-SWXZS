<?php
        	
namespace Addons\Xwts\Model;
use Home\Model\WeixinModel;
        	
/**
 * Xwts的微信模型
 */
class WeixinAddonModel extends WeixinModel{
	function reply($dataArr, $keywordArr = array()) {
		$config = getAddonConfig ( 'Xwts' ); // 获取后台插件的配置参数

        $param ['token'] = get_token ();
        $param ['openid'] = get_openid ();

        $aim_id = $keywordArr['aim_id'] ? $keywordArr['aim_id'] : 4; //默认为活动通知
        $typeHash = array(
          "1" => "生物热点资讯",
          "2" => "教师技能培训",
          "3" => "考研出国贴士",
          "4" => "活动通知"
        );
        $randomNum = rand(1, 4);
        $typeText = $aim_id == 0 ? $typeHash[$randomNum] : $typeHash[$aim_id];

        $list = M ( 'weisite_category' )->where ( array("title" => $typeText, "token" => $param['token']) )->field ( 'id,title' )->find ();
        $cate_id = $list['id'];

        $custom_replys = M('custom_reply_news')->where(array("cate_id" => $cate_id, "token" => $param['token']))->order('sort')->select();
        $count_custom_replys = count($custom_replys);
        $count = $count_custom_replys < $config['num'] ? $count_custom_replys : $config['num'];
        $article = array();
        for($i = 0; $i < $count; $i++){
            $article[] = array(
                'Title'=> $custom_replys[$i]['title'],
                'Description'=> $custom_replys[$i]['intro'],
                'PicUrl'=> get_cover_url($custom_replys[$i]['cover']),
                'Url'=> $this->_getNewsUrl ( $custom_replys[$i], $param )
            );
        }

		$this->replyNews($article);

	}
    private function _getNewsUrl($info, $param) {
        if (! empty ( $info ['jump_url'] )) {
            $url = replace_url ( $info ['jump_url'] );
        } else {
            $param ['id'] = $info ['id'];
            $url = addons_url ( 'CustomReply://CustomReply/detail', $param );
        }
        return $url;
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
        	