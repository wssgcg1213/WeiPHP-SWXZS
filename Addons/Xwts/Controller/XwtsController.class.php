<?php

namespace Addons\Xwts\Controller;
use Home\Controller\AddonsController;

class XwtsController extends AddonsController{
    var $config;
    function _initialize() {
        parent::_initialize();

        $controller = strtolower ( _CONTROLLER );

        $res ['title'] = '新闻推送';
        $res ['url'] = addons_url ( 'CustomReply://CustomReply/lists' );
        $res ['class'] = $controller == 'customreply' ? 'current' : '';
        $nav [] = $res;

        $this->assign ( 'nav', $nav );

        $config = getAddonConfig ( 'CustomReply' );
        $config ['cover_url'] = get_cover_url ( $config ['cover'] );
        $this->config = $config;
        $this->assign ( 'config', $config );
        // dump ( $config );
        // dump(get_token());
    }
}
