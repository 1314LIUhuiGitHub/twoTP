<?php
/**
 * Created by PhpStorm.
 * User: 刘辉
 * Date: 2018/5/13
 * Time: 13:33
 */

namespace app\admin\validate;


use think\Validate;

class Property extends Validate
{
    protected $rule = [
        ['name', 'require', '报修人必填'],
        ['tel', 'require', '联系电话必填'],
        ['tel', ['^1([358][0-9]|4[579]|66|7[0135678]|9[89])[0-9]{8}$'], '手机号码格式错误'],
        ['intro', 'require', '详细地址必填'],
        ['address', 'require', '地址必填'],
    ];
}