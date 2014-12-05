<?php

namespace Addons\UserCenter;

use Common\Controller\Addon;

/**
 * 微信用户中心插件
 * 
 * @author 无名
 */
class UserCenterAddon extends Addon {
	public $info = array (
			'name' => 'UserCenter',
			'title' => '微信用户中心',
			'description' => '实现微信用户绑定，微信用户信息初始化等基本功能',
			'status' => 1,
			'author' => 'Ling',
			'version' => '0.2' 
	);
	public $admin_list = array ();

	public function install() {
		$install_sql = './Addons/UserCenter/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}

	public function uninstall() {
		$uninstall_sql = './Addons/UserCenter/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}
	
	// 实现的weixin钩子方法
	public function weixin($param) {
	}
}