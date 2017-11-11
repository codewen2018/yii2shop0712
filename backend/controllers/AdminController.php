<?php

namespace backend\controllers;

use backend\models\Admin;
use backend\models\LoginForm;

class AdminController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAdd()
    {
        //创建管理员
        $admin=new Admin();
        $admin->username="admin";
        $admin->password_hash="123456";
        //加密
        $admin->password_hash=\Yii::$app->security->generatePasswordHash($admin->password_hash);
        //随机字符串
        $admin->auth_key=\Yii::$app->security->generateRandomString();
        $admin->save();

        //找到角色对象
        $auth=\Yii::$app->authManager;
        //找到admin角色
        $role=$auth->getRole('admin');
        //把当前用户对象追加到admin角中
        $auth->assign($role,$admin->id);

        \Yii::$app->session->setFlash("success",'注册成功');
       // \Yii::$app->user->login($admin,3600*24*7);
        return $this->redirect(['index']);
        //var_dump($admin->getErrors());

        
    }

    /**
     * 登录
     */
    public function actionLogin()
    {

        //实例化表单模型
        $model=new LoginForm();

        //判断是不是Post
        $request=\Yii::$app->request;

        if ($request->isPost){

            //数据绑定
            $model->load($request->post());

            if ($model->validate()){
                //根据用户名把用户对象查出来
                $admin=Admin::findOne(['username'=>$model->username]);

                if ($admin){
                 //存在 判断密码
                    if (\Yii::$app->security->validatePassword($model->password,$admin->password_hash)){



                        //执行登录
                        \Yii::$app->user->login($admin,$model->rememberMe?3600*24*7:0);
                        //跳转
                        return $this->redirect(['index']);

                    }else{
                        //密码错误
                        $model->addError("password","密码错误");

                    }


                }else{
                    //不存在 提示没用用户名
                    $model->addError("username","用户名不存在");



                }






            }







        }

        //显示视图
        return $this->render("login", ['model' => $model]);
        
    }


    public function actionLogout(){

       //var_dump(\Yii::$app->user->identity);

       \Yii::$app->user->logout();

       return $this->redirect(['login']);



    }
}
