<?php
        	
namespace Addons\Cjcx\Model;
use Home\Model\WeixinModel;
        	
/**
 * Cjcx的微信模型
 */
class WeixinAddonModel extends WeixinModel{
	function reply($dataArr, $keywordArr = array()) {
		$config = getAddonConfig ( 'Cjcx' ); // 获取后台插件的配置参数
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
            return '老师是没有考试成绩的0.0';
        }else{
            $textArr = array();
            $userGrades = M('cjcx')->where(array('school_id' => $user['school_id'], 'term' => $config['term']))->select();
            foreach($userGrades as $item){
                $_t = '';
                $_t .= "课程名称: {$item['course_name']},\n";
                $_t .= "课程属性: {$item['class_type']}, \n";
                $_t .= "学分: {$item['study_score']},\n";
                $_t .= "分数: {$item['stu_grade']}";
                array_push($textArr, $_t);
            }
            $basic = implode("\n\n", $textArr);
            $params['openid'] = get_openid();
            $params['token'] = get_token();
            $more = "\n\n"."<a href='".addons_url("Cjcx://Cjcx/center", $params)."'>查看完整记录</a>";
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
        	