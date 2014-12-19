<?php

namespace Addons\Xytl;
use Common\Controller\Addon;

/**
 * 学院通联插件
 * @author 刘晨凌
 */

    class XytlAddon extends Addon{

        public $info = array(
            'name'=>'Xytl',
            'title'=>'学院通联',
            'description'=>'学院通联',
            'status'=>1,
            'author'=>'刘晨凌',
            'version'=>'0.1',
            'has_adminlist'=>1,
            'type'=>1         
        );

	public function install() {
		$install_sql = './Addons/Xytl/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/Xytl/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }