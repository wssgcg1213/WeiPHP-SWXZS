<?php

namespace Addons\Xwts;
use Common\Controller\Addon;

/**
 * 生物小助手新闻推送插件
 * @author 刘晨凌
 */

    class XwtsAddon extends Addon{

        public $info = array(
            'name'=>'Xwts',
            'title'=>'生物小助手新闻推送',
            'description'=>'生物小助手新闻推送, 包括了考研出国贴士,教师技能培训,生物热点资讯,活动通知',
            'status'=>1,
            'author'=>'刘晨凌',
            'version'=>'0.1',
            'has_adminlist'=>1,
            'type'=>1         
        );

	public function install() {
		$install_sql = './Addons/Xwts/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/Xwts/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }