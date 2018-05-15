<?php
/**
 * Created by PhpStorm.
 * User: 刘辉
 * Date: 2018/5/13
 * Time: 13:26
 */

namespace app\admin\model;

use think\Model;

class Property extends  Model
{
    protected $autoWriteTimestamp=true;
    // 新增
    //属性修改器
    protected function setTitleAttr($value, $data)
    {
        return htmlspecialchars($value);
    }
}