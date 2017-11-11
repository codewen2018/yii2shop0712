<?php

namespace backend\controllers;

use backend\models\AuthItem;
use yii\helpers\ArrayHelper;

class RoleController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //实例化RBAC组件
        $authManager=\Yii::$app->authManager;
        //显示权限  把所有权限查出来
        $roles=$authManager->getRoles();




       // var_dump($permissions);exit;

        return $this->render('index',compact('roles'));
    }


    public function actionAdd()
    {

        $model=new  AuthItem();
        //实例化RBAC组件
        $authManager=\Yii::$app->authManager;
         $request=\Yii::$app->request;
         if ($model->load($request->post()) && $model->validate()){

           //  var_dump($model->permissions);exit;
             //创建权限
             $role=$authManager->createRole($model->name);
             //添加描述
             $role->description=$model->description;
             //添加权限 把权限添加到数据库
             if ($authManager->add($role)){

                 //给用户添加权限

                 if ($model->permissions){
                     foreach ($model->permissions as $permission){
                         //通过权限名称得到权限对象

                         //分别把权限名称添加到对应的角色中
                         $authManager->addChild($role,$authManager->getPermission($permission));


                     }
                 }




             }

             \Yii::$app->session->setFlash("success","创建".$model->description."成功");
             return $this->redirect(['index']);


         }

         //var_dump($model->getErrors());exit;

        //得到所有权限

        $permissions=$authManager->getPermissions();
         $permissions=ArrayHelper::map($permissions,"name","description");

       //  var_dump($permissions);exit;

        return $this->render("add",compact('model','permissions'));

    }


    public function actionEdit($name)
    {

        //$model=new  AuthItem();
        //实例化RBAC组件
        $authManager=\Yii::$app->authManager;
        $model=AuthItem::findOne($name);

        //通过角色得到角色的所有权限
         $rolePermission=$authManager->getPermissionsByRole($name);
         //取数组所有键
         //var_dump(array_keys($rolePermission));exit;
        $model->permissions=array_keys($rolePermission);
        $request=\Yii::$app->request;
        if ($model->load($request->post()) && $model->validate()){

            //找出当前权限对象
           // $permission=$authManager->createPermission($model->name);
            $role=$authManager->getRole($model->name);
            if ($role){

                //添加描述
                $role->description=$model->description;
                //修改权限 把权限修改到数据库
                //添加权限 把权限添加到数据库
                if ($authManager->update($model->name,$role)){

                    //在添加权限之前删除当前角色所有的权限
                    $authManager->removeChildren($role);
                    //给用户添加权限

                    if ($model->permissions){
                        foreach ($model->permissions as $permission){
                            //通过权限名称得到权限对象

                            //分别把权限名称添加到对应的角色中
                            $authManager->addChild($role,$authManager->getPermission($permission));


                        }
                    }




                }

                \Yii::$app->session->setFlash("success","修改".$model->description."成功");

                return $this->redirect(['index']);

            }else{

                \Yii::$app->session->setFlash("danger","不能修改角色名称".$model->name);
                return $this->refresh();

            }



        }

        //var_dump($model->getErrors());exit;
        $permissions=$authManager->getPermissions();
        $permissions=ArrayHelper::map($permissions,"name","description");

        return $this->render("add",compact('model','permissions'));

    }


    public function actionDel($name)
    {
        $auth=\Yii::$app->authManager;
        //找到要删除的角色对象
        $role=$auth->getRole($name);

        //删除当前角色所有权限
        $auth->removeChildren($role);

        //删除角色
        if ( $auth->remove($role)){
            \Yii::$app->session->setFlash("success","删除".$name."成功");
            return $this->redirect(["index"]);

        }

    }


}
