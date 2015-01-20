<?php

namespace Addons\Swtz;
use Common\Controller\Addon;

/**
 * 教师或学生通知插件
 * @author Ling
 */

    class SwtzAddon extends Addon{

        public $info = array(
            'name'=>'Swtz',
            'title'=>'教师或学生通知',
            'description'=>'• 教师通知：只有教师能看到，学院发给教师的通知
• 学生通知：一些教务方面的、或学院的关于学生通知',
            'status'=>1,
            'author'=>'Ling',
            'version'=>'0.0.1',
            'has_adminlist'=>1,
            'type'=>1         
        );

	public function install() {
		$install_sql = './Addons/Swtz/install.sql';
		if (file_exists ( $install_sql )) {
			execute_sql_file ( $install_sql );
		}
		return true;
	}
	public function uninstall() {
		$uninstall_sql = './Addons/Swtz/uninstall.sql';
		if (file_exists ( $uninstall_sql )) {
			execute_sql_file ( $uninstall_sql );
		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }