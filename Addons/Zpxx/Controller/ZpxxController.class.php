<?php

namespace Addons\Zpxx\Controller;
use Home\Controller\AddonsController;

class ZpxxController extends AddonsController{
    public function catch(){
        $source = wp_file_get_contents('http://job.snnu.edu.cn/index.html');

		preg_match_all("/\[\d{2}\-\d{2} \d{2}:\d{2}\]/", $source, $times);
		preg_match_all("/com\/show_info\.asp\?com_id=(\d{1,})/", $source, $urls);
		
		$result = array();

		foreach ($times as $k => $t) {
			$tmp = array(
				"time" => $t,
				"url_id" => $urls[1][$k]
			);
		}
    }

    private function get_content_by_url_id($id){
    	$url = "http://job.snnu.edu.cn/com/show_info.asp?com_id=$id&com_version=0&action=com_info";
    	$source = wp_file_get_contents($url);
  		$s = mb_convert_encoding($source, "UTF-8", "GB18030");
  		preg_match_all("/<div id=attitle>([^>]+)<\/div>/i", $s , $_title);
      preg_match_all("/<div id=dwinfor align=\"center\">([^\n]+).*/i", $s, $_subContent);
      preg_match_all("/<p><font style=([^\n]+).*/i", $s, $_mainContent);
  		$title = trim($_title[1][0]);
      $content = $_subContent.$_mainContent;
  		return array(
          "title" => $title,
          "content" => $content
      );

    }
}
