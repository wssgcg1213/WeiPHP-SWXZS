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
            if(!$vo ['cate_id']){
                unset($list_data ['list_data'][array_search($vo , $list_data ['list_data'])]);
            }
        }
//        echo json_encode($list_data);
        $this->assign ( $list_data );
        // dump ( $list_data );

        $templateFile = $this->model ['template_list'] ? $this->model ['template_list'] : '';
        $this->display ( $templateFile );
    }

//    // 通用插件的编辑模型
//    public function edit($model = null, $id = 0) {
//        is_array ( $model ) || $model = $this->getModel ( 'custom_reply_news' );
//        $templateFile = $this->getAddonTemplate ( $model ['template_edit'] );
//        parent::common_edit ( $model, $id, $templateFile );
//    }
    public function edit() {
        $model = $this->getModel('custom_reply_news');
        $id = I ( 'id' );

        if (IS_POST) {
            $Model = D ( parse_name ( get_table_name ( $model ['id'] ), 1 ) );
            // 获取模型的字段信息
            $Model = $this->checkAttr ( $Model, $model ['id'] );
            if ($Model->create () && $Model->save ()) {
                $this->_saveKeyword ( $model, $id, 'custom_reply_news' );

                $this->success ( '保存' . $model ['title'] . '成功！', U ( 'lists?model=' . $model ['name'] ) );
            } else {
                $this->error ( $Model->getError () );
            }
        } else {
            $fields = get_model_attribute ( $model ['id'] );

            $extra = $this->getCateData ();
            if (! empty ( $extra )) {
                foreach ( $fields [1] as &$vo ) {
                    if ($vo ['name'] == 'cate_id') {
                        $vo ['extra'] .= "\r\n" . $extra;
                    }
                }
            }

            // 获取数据
            $data = M ( get_table_name ( $model ['id'] ) )->find ( $id );
            $data || $this->error ( '数据不存在！' );

            $token = get_token ();
            if (isset ( $data ['token'] ) && $token != $data ['token'] && defined ( 'ADDON_PUBLIC_PATH' )) {
                $this->error ( '非法访问！' );
            }

            $this->assign ( 'fields', $fields );
            $this->assign ( 'data', $data );
            $this->meta_title = '编辑' . $model ['title'];

            $this->display ();
        }
    }

    // 通用插件的增加模型
    public function add() {
        $model = $this->getModel ( 'custom_reply_news' );
        $Model = D ( parse_name ( get_table_name ( $model ['id'] ), 1 ) );

        if (IS_POST) {
            if(I('cate_id') == 0){
                $this->error ( '请指定所属类别!' );
            }
            // 获取模型的字段信息
            $Model = $this->checkAttr ( $Model, $model ['id'] );
            if ($Model->create () && $id = $Model->add ()) {
                $this->_saveKeyword ( $model, $id, 'custom_reply_news' );

                $this->success ( '添加' . $model ['title'] . '成功！', U ( 'lists?model=' . $model ['name'] ) );
            } else {
                $this->error ( $Model->getError () );
            }
        } else {
            $fields = get_model_attribute ( $model ['id'] );

            $extra = $this->getCateData ();
            if (! empty ( $extra )) {
                foreach ( $fields [1] as &$vo ) {
                    if ($vo ['name'] == 'cate_id') {
                        $vo ['extra'] .= "\r\n" . $extra;
                    }
                }
            }

            $this->assign ( 'fields', $fields );
            $this->meta_title = '新增' . $model ['title'];

            $this->display ();
        }
    }

    // 通用插件的删除模型
    public function del($model = null, $ids = null) {
        parent::common_del ( 'custom_reply_news', $ids );
    }

    // 重写的保存关键词方法
    public function _saveKeyword($model, $id, $extra_text) {
        D ( 'Common/Keyword' )->set ( $_POST ['keyword'], _ADDONS, $id, $_POST ['keyword_type'], $extra_text );
    }

    // 获取所属分类
    function getCateData() {
        $map ['is_show'] = 1;
        $map ['token'] = get_token ();
        $list = M ( 'weisite_category' )->where ( $map )->select ();
        foreach ( $list as $v ) {
            $extra .= $v ['id'] . ':' . $v ['title'] . "\r\n";
        }
        return $extra;
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
