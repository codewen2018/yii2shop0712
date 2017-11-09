<?php
/**
 * Created by PhpStorm.
 * Email: wenmang2015@qq.com
 * Date: 2017/11/9
 * Time: 10:06
 * Company: 源码时代重庆校区
 */

namespace backend\models;


use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;
    //记住我,默认勾选
    public $rememberMe = true;


    public function rules()
    {
        return [
            [['username','password'],'required'],
            [['rememberMe'],'safe']
        ];
    }

    public function attributeLabels()
    {
        return [

            'username'=>"用户名",
            'password_hash'=>'密码'

        ];
    }
}