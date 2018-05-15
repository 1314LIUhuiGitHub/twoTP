<?php
/**
 * Created by PhpStorm.
 * User: 刘辉
 * Date: 2018/5/13
 * Time: 11:35
 */

namespace app\admin\controller;


use think\Process;

class Property extends Admin{
    //显示列表
  public function index(){
      //获得搜索的字符
      $title=trim(input('title'));
      if ($title){
          $map['name'] = array('like',"%{$title}%");
          $Property= \think\Db::name("property")->where($map)->field(true)->order('id asc')->paginate(1,false,['query'=>request()->param()]);
      }else{
          $Property=\app\admin\model\Property::paginate(1);
      }
      $page=$Property->render();
      $this->assign('Property', $Property);
      $this->assign('page', $page);
      return $this->fetch();
  }
  //添加信息
  public function add(){
      if (request()->isPost()){
          $Property = model('Property');
          $post_data=request()->post();
          //添加维修编号
          $post_data['number']=strtoupper(uniqid());
          $validate = validate('Property');
          if(!$validate->check($post_data)){
              return $this->error($validate->getError());
          }
          $data = $Property->create($post_data);
          if($data){
              session('admin_property_index',null);
              //记录行为
              action_log('add_property', 'Property', $data->id, UID);
              $this->success('新增成功', url('index'));
          } else {
              $this->error($Property->getError());
          }
      }else{
          return $this->fetch('edit');
      }

  }
  //修改信息
  public function edit($id=0){
    if (request()->isPost()){
        //保存修改信息
        $Property = model('Property');
        //接收提交过来的信息
        $post_data=$this->request->post();
        //得到验证规则
        $validate = validate('Property');
        //验证规则
        if(!$validate->check($post_data)){
            //不通过显示错误
            return $this->error($validate->getError());
        }
        $data = $Property->update($post_data);
        if($data){
            session('admin_Property_list',null);
            //记录行为
            action_log('update_Property', 'Property', $data->id, UID);
            $this->success('更新成功', url('index'));
        } else {
            $this->error($Property->getError());
        }
    }else{
        //获取指定id信息
        $Property=\app\admin\model\Property::field(true)->find($id);
        if(false === $Property){
            //错误提示
            $this->error('获取后台信息错误');
        }
        $this->assign('Property', $Property);
        return $this->fetch();
    }
    }
  //删除信息
  public function del(){
      $id = array_unique((array)input('id/a',0));
      if ( empty($id) ) {
          $this->error('请选择要操作的数据!');
      }
      $map = array('id' => array('in', $id) );
      if(\think\Db::name('property')->where($map)->delete()){
          session('admin_property_list',null);
          //记录行为
          action_log('update_Property', 'Property', $id, UID);
          $this->success('删除成功');
      } else {
          $this->error('删除失败！');
      }
  }
}