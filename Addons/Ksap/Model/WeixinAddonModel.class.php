<?php
        	
namespace Addons\Ksap\Model;
use Home\Model\WeixinModel;
        	
/**
 * Ksap的微信模型
 */
class WeixinAddonModel extends WeixinModel{
	function reply($dataArr, $keywordArr = array()) {
		$config = getAddonConfig ( 'Ksap' ); // 获取后台插件的配置参数	
		//dump($config);
        $map['openid'] = get_openid();
        $map['token'] = get_token();

        $user = M('swuser')->where($map)->find();

        $text = $this->formText($user, $config);
        $this->replyText($text);
	}

    private function formText($user, $config){
        if(!$user){
            return '请先回复绑定并绑定真实信息以使用本功能.';
        }
        if($user['user_type'] == 1){
            return '老师是没有考试安排的0.0';
        }else{
            $textArr = array();
            $userSchedules = M('ksap')->where(array('school_id' => $user['school_id'], 'term' => $config['term']))->select();

            if(0 == count($userSchedules)){
                return "空记录! 还没更新呢!";
            }
            
            foreach($userSchedules as $item){
                $_t = '';
                $_t .= "科目: {$item['course']},\n";
                $_t .= "日期: {$item['date']}, \n";
                $_t .= "时间: {$item['time']},\n";
                $_t .= "教室: {$item['room']}";
                array_push($textArr, $_t);
            }
            $basic = implode("\n\n", $textArr);
            $params['openid'] = get_openid();
            $params['token'] = get_token();
            $more = "\n\n"."<a href='".addons_url("Ksap://Ksap/center", $params)."'>查看完整记录</a>";
            return $basic.$more;
        }
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
        	