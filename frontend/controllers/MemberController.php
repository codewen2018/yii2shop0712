<?php

namespace frontend\controllers;

use frontend\models\Member;

class MemberController extends \yii\web\Controller
{

    public $layout="login";
    public function actionReg()
    {
        $model=new Member();
        return $this->render('reg',compact('model'));
    }

}
