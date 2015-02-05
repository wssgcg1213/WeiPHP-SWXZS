<?php

namespace Addons\Yjfk;
use Common\Controller\Addon;

/**
 * 意见反馈插件
 * @author Ling
 */

    class YjfkAddon extends Addon{

        public $info = array(
            'name'=>'Yjfk',
            'title'=>'意见反馈',
            'description'=>'生物小助手 意见反馈',
            'status'=>1,
            'author'=>'Ling',
            'version'=>'0.1',
            'has_adminlist'=>0,
            'type'=>1         
        );

	public function install() {
		$install_sql = './Addons/Yjfk/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/Yjfk/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }