<?php

namespace Addons\Zpxx\Controller;
use Home\Controller\AddonsController;

class ZpxxController extends AddonsController{
    public function test(){
        $source = wp_file_get_contents('http://job.snnu.edu.cn/index.html');
        echo $source;
    }
}
