<?php
/**
 * Created by PhpStorm.
 * User: 刘辉
 * Date: 2018/5/14
 * Time: 16:24
 */

namespace app\home\controller;


use think\Controller;
use think\Db;

class My extends Controller{
    //我的主页
    public function show(){
        //显示视图
        $id=is_login();
        $member=Db::name('member')->find($id);
        

        return $this->fetch('default/my/my');
    }
}