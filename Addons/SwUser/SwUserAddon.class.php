<?php

namespace Addons\SwUser;
use Common\Controller\Addon;

/**
 * 生物小助手用户中心插件
 * @author 刘晨凌
 */

    class SwUserAddon extends Addon{

        public $info = array(
            'name'=>'SwUser',
            'title'=>'生物小助手用户中心',
            'description'=>'生物小助手用户中心
管理绑定',
            'status'=>1,
            'author'=>'刘晨凌',
            'version'=>'0.1',
            'has_adminlist'=>0,
            'type'=>1         
        );

	public function install() {
		$install_sql = './Addons/SwUser/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/SwUser/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }