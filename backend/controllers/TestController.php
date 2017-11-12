<?php
/**
 * Created by PhpStorm.
 * Email: wenmang2015@qq.com
 * Date: 2017/11/3
 * Time: 21:20
 * Company: 源码时代重庆校区
 */

namespace backend\controllers;


use backend\components\RbacMenu;
use backend\models\Me;
use yii\web\Controller;

class TestController extends Controller
{

    public function actionIndex()
    {

        RbacMenu::Menu();
        // return $this->render('index');


    }

    public function actionTest()
    {

        $str1 = "wo@iphp@3432";
        $str2 = rand(100000, 999999);
        echo md5($str1 . '123456' . time());
        echo "<br>";
        $str2 = rand(100000, 999999);
        echo md5($str1 . '123456' . $str2);


    }

    public static function actionMenu()
    {

        $aaa = [
            'label' => 'Level One',
            'icon' => 'circle-o',
            'url' => '#',
            'items' => [
                ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                [
                    'label' => 'Level Two',
                    'icon' => 'circle-o',
                    'url' => '#',
                    'items' => [
                        ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                        ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                    ],
                ],
            ],
        ];
        //得到所有一级目录
        $me1 = Me::find()->where(['parent_id' => 0])->all();
        $menuArr = [];
        foreach ($me1 as $k => $v) {

            $menu = [
                'label' => $v->name,
                'icon' => 'fighter-jet',
                'url' => "#",
                'visible' => \Yii::$app->user->can($v->name)

            ];
            //找到当分类所有儿子
            $childs = Me::find()->where(['parent_id' => $v->id])->all();
            if ($childs) {
                foreach ($childs as $child) {

                    $menu['items'][] = [
                        'label' => $child->name,
                        'icon' => 'circle-o',
                        'url' => "/".$child->url,
                       // 'visible' => \Yii::$app->user->can($child->url)
                    ];
                }


            }else{
                $menu['visible']=false;
            }
            $menu['visible']=true;


            $menuArr[]=$menu;

        }
      //  [\backend\controllers\TestController::actionMenu(),\backend\controllers\TestController::actionMenu(),]
        return $menuArr;

    }


}