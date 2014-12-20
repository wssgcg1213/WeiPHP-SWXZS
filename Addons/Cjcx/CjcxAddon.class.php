<?php

namespace Addons\Cjcx;
use Common\Controller\Addon;

/**
 * 成绩查询插件
 * @author 刘晨凌
 */

    class CjcxAddon extends Addon{

        public $info = array(
            'name'=>'Cjcx',
            'title'=>'成绩查询',
            'description'=>'[生物]成绩查询',
            'status'=>1,
            'author'=>'刘晨凌',
            'version'=>'0.1',
            'has_adminlist'=>1,
            'type'=>1         
        );

	public function install() {
		$install_sql = './Addons/Cjcx/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/Cjcx/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }