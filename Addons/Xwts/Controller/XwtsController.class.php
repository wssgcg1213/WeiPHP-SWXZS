<?php

namespace Addons\Xwts\Controller;
use Home\Controller\AddonsController;

class XwtsController extends AddonsController{
//    var $config;
//    function _initialize() {
//        parent::_initialize();
//
//        $controller = strtolower ( _CONTROLLER );
//
//        $res ['title'] = '新闻推送';
//        $res ['url'] = addons_url ( 'CustomReply://CustomReply/lists' );
//        $res ['class'] = $controller == 'customreply' ? 'current' : '';
//        $nav [] = $res;
//
//        $this->assign ( 'nav', $nav );
//
//        $config = getAddonConfig ( 'CustomReply' );
//        $config ['cover_url'] = get_cover_url ( $config ['cover'] );
//        $this->config = $config;
//        $this->assign ( 'config', $config );
//        // dump ( $config );
//        // dump(get_token());
//    }
    public function lists($model = null, $page = 0) {
//        $model = $this->getModel ( 'custom_reply_news' );
//        $templateFile = $this->getAddonTemplate ( $model ['template_list'] );
//        $order = 'id desc';
//        $list_data = $this->_get_model_list ( $model, $page, $order );
//        $this->assign ( $list_data );
//        // dump($list_data);
//        $templateFile || $templateFile = $model ['template_list'] ? $model ['template_list'] : '';
//        $this->display ( $templateFile );
        $model = $this->getModel ( 'custom_reply_news' );
        $map ['token'] = get_token ();
        session ( 'common_condition', $map );

        $list_data = $this->_get_model_list ( $model );

        // 分类数据
        $map ['is_show'] = 1;
        $list = M ( 'weisite_category' )->where ( $map )->field ( 'id,title' )->select ();
        $cate [0] = '';
        foreach ( $list as $vo ) {
            $cate [$vo ['id']] = $vo ['title'];
        }

        foreach ( $list_data ['list_data'] as &$vo ) {
            $vo ['cate_id'] = intval ( $vo ['cate_id'] );
            $vo ['cate_id'] = $cate [$vo ['cate_id']];
        }
        echo json_encode($list_data);
        $this->assign ( $list_data );
        // dump ( $list_data );

        $templateFile = $this->model ['template_list'] ? $this->model ['template_list'] : '';
        $this->display ( $templateFile );
    }

    // 通用插件的编辑模型
    public function edit($model = null, $id = 0) {
        is_array ( $model ) || $model = $this->getModel ( 'custom_reply_news' );
        $templateFile = $this->getAddonTemplate ( $model ['template_edit'] );
        parent::common_edit ( $model, $id, $templateFile );
    }

    // 通用插件的增加模型
    public function add($model = null) {
        is_array ( $model ) || $model = $this->getModel ( 'custom_reply_news' );
        $templateFile = $this->getAddonTemplate ( $model ['template_add'] );

        parent::common_add ( $model, $templateFile );
    }

    // 通用插件的删除模型
    public function del($model = null, $ids = null) {
        parent::common_del ( 'custom_reply_news', $ids );
    }

    public function _get_model_list($model = null, $page = 0, $order = 'id desc') {
        $page || $page = I ( 'p', 1, 'intval' ); // 默认显示第一页数据

        // 解析列表规则
        $list_data = $this->_list_grid ( $model );
        $grids = $list_data ['list_grids'];
        $fields = $list_data ['fields'];

        // 搜索条件
        $map = $this->_search_map ( $model, $fields );

        $row = empty ( $model ['list_row'] ) ? 20 : $model ['list_row'];

        // 读取模型数据列表
        if ($model ['extend']) {
            $name = get_table_name ( $model ['id'] );
            $parent = get_table_name ( $model ['extend'] );
            $fix = C ( "DB_PREFIX" );

            $key = array_search ( 'id', $fields );
            if (false === $key) {
                array_push ( $fields, "{$fix}{$parent}.id as id" );
            } else {
                $fields [$key] = "{$fix}{$parent}.id as id";
            }

            /* 查询记录数 */
            $count = M ( $parent )->join ( "INNER JOIN {$fix}{$name} ON {$fix}{$parent}.id = {$fix}{$name}.id" )->where ( $map )->count ();

            // 查询数据
            $data = M ( $parent )->join ( "INNER JOIN {$fix}{$name} ON {$fix}{$parent}.id = {$fix}{$name}.id" )->field ( empty ( $fields ) ? true : $fields )->where ( $map )->order ( "{$fix}{$parent}.{$order}" )->page ( $page, $row )->select ();
        } else {
            empty ( $fields ) || in_array ( 'id', $fields ) || array_push ( $fields, 'id' );
            $name = parse_name ( get_table_name ( $model ['id'] ), true );
            $data = M ( $name )->field ( empty ( $fields ) ? true : $fields )->where ( $map )->order ( $order )->page ( $page, $row )->select ();

            /* 查询记录总数 */
            $count = M ( $name )->where ( $map )->count ();
        }
        $list_data ['list_data'] = $data;

        // 分页
        if ($count > $row) {
            $page = new \Think\Page ( $count, $row );
            $page->setConfig ( 'theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%' );
            $list_data ['_page'] = $page->show ();
        }
//        echo(json_encode($list_data));
        return $list_data;
    }

    public function center(){
        $map['token'] = get_token();
        $map['openid'] = get_openid();
        $user = M('swuser')->where($map)->find();
        if(!$user){
            $this->error("用户非法!");
        }

        $mapTz ['id'] = I ( 'get.id', 0, 'intval' );
        $info = M ( 'xwts' )->where ( $mapTz )->find ();

        if($user['user_type'] == 0){ //学生
            if($info['type'] != 0){
                $this->error("用户非法!");
            }
        }elseif($user['user_type'] == 1){ //老师
            if($info['type'] != 1){
                $this->error("用户非法!");
            }
        }

        $this->assign ( 'info', $info );

        $this->display('center');
    }
}
