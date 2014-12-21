<?php

namespace Addons\Zpxx\Controller;
use Home\Controller\AddonsController;

class ZpxxController extends AddonsController{

    public function fetch(){
        $source = wp_file_get_contents('http://job.snnu.edu.cn/index.html');

		preg_match_all("/\[\d{2}\-\d{2} \d{2}:\d{2}\]/", $source, $times);
		preg_match_all("/com\/show_info\.asp\?com_id=(\d{1,})/", $source, $urls);

        $model = M('zpxx');
		$result = array();
		foreach ($times[0] as $k => $t) {
            $c = $this->get_content_by_url_id($urls[1][$k]);
            $tmp = array(
				"time" => $t,
                "title" => $c['title'],
				"url" => $c['url']
			);
            if(!$model->where(array("title" => $c['title']))->find()){
                $model->add($tmp);
                $result[] = $tmp;
            }
		}

        echo json_encode($result);
    }

    private function get_content_by_url_id($id){
    	$url = "http://job.snnu.edu.cn/com/show_info.asp?com_id=$id&com_version=0&action=com_info";
    	$source = wp_file_get_contents($url);
  		$s = mb_convert_encoding($source, "UTF-8", "GB18030");
  		preg_match_all("/<div id=attitle>([^>]+)<\/div>/i", $s , $_title);
//        preg_match_all("/<div id=dwinfor align=\"center\">([^\n]+).*/i", $s, $_subContent);
//        preg_match_all("/<FONT style=([^\n]+).*/i", $s, $_mainContent);
  		$title = trim($_title[1][0]);
//        $content = $_subContent[0][0].$_mainContent[0][0];
  		return array(
          "title" => $title,
          "url" => $url
        );
    }
}
