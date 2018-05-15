<?php
/**
 * Created by PhpStorm.
 * User: 刘辉
 * Date: 2018/5/14
 * Time: 12:51
 */

namespace app\home\controller;

use think\Controller;
use think\Db;
use think\Validate;

class Sort extends Controller
{
    //通知消息
    public function notice()
    {
        //查询通知信息
        $notice = Db::name('document')->where('category_id', 43)->field(true)->select();
        //分配通知信息
        $this->assign('notice', $notice);
        //加载视图
        return $this->fetch('default/sort/notice');
    }
    //通知详情
    public function detail()
    {
        //获取点击文章时的id
        $id = input('id');
        //查询对应文章的详情
        $detail = Db::name('document_article')->field(true)->find($id);
        //分配详情数据
        $this->assign('detail', $detail);
        //查询通知信息
        $notice = Db::name('document')->field(true)->find($id);
        //通知浏览数+1
        Db::name('document')->where('id', $id)->setInc('view', 1);
        //分配通知信息
        $this->assign('notice', $notice);
        //加载视图
        return $this->fetch('default/sort/notice-detail');
    }
    //在线报修
    public function online()
    {
        if (request()->isPost()){
            $online=request()->post();
            $validate = new Validate([
                ['title', 'require', '标题必填'],
                ['name', 'require', '报修人必填'],
                ['tel', 'require', '联系电话必填'],
                ['tel', ['^1([358][0-9]|4[579]|66|7[0135678]|9[89])[0-9]{8}$'], '手机号码格式错误'],
                ['intro', 'require', '详细地址必填'],
                ['address', 'require', '地址必填'],
            ]);
            if (!$validate->check($online)) {
                return $this->error($validate->getError());
            }
            $online['number']=strtoupper(uniqid());
            Db::name('property')->insert($online);
            $this->success('报修成功', url('index/index'));
        }else{
            return $this->fetch('default/sort/online');
        }
    }
    //便民服务
    public function service(){
        $service = Db::name('document')->where('category_id', 44)->field(true)->select();
        //分配通知信息
        $this->assign('service', $service);
        return $this->fetch('default/sort/service');
    }
    //便民详情
    public function service_detail(){
        //获取点击文章时的id
        $id = input('id');
        //查询对应文章的详情
        $detail = Db::name('document')->field(true)->find($id);
        Db::name('document')->where('id', $id)->setInc('view', 1);
        $this->assign('detail', $detail);
        return $this->fetch('default/sort/service-detail');
    }
    //我的详情页

}