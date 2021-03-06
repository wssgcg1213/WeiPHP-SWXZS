<?php

namespace Addons\Zpxx;
use Common\Controller\Addon;

/**
 * 招聘信息插件
 * @author 刘晨凌
 */

    class ZpxxAddon extends Addon{

        public $info = array(
            'name'=>'Zpxx',
            'title'=>'招聘信息',
            'description'=>'招聘信息',
            'status'=>1,
            'author'=>'刘晨凌',
            'version'=>'0.1',
            'has_adminlist'=>0,
            'type'=>1         
        );

	public function install() {
		$install_sql = './Addons/Zpxx/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/Zpxx/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }