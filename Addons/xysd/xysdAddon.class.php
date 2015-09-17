<?php

namespace Addons\xysd;
use Common\Controller\Addon;

/**
 * 学院树洞插件
 * @author Ling
 */

class xysdAddon extends Addon{
    public $info = array(
        'name'=>'xysd',
        'title'=>'学院树洞',
        'description'=>'学院树洞',
        'status'=>1,
        'author'=>'Ling',
        'version'=>'0.1',
        'has_adminlist'=>1,
        'type'=>1
    );

	public function install() {
		$install_sql = './Addons/xysd/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}

	public function uninstall() {
		$uninstall_sql = './Addons/xysd/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

    //实现的weixin钩子方法
    public function weixin($param){

    }
}