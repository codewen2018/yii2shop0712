<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($article,'name');
echo $form->field($article,'article_category_id')->dropDownList($catesArr);
echo $form->field($article,'status')->radioList(['1'=>'显示','0'=>'隐藏']);

echo $form->field($article,'sort');
echo $form->field($article,'intro')->textarea();
echo $form->field($articleDetail,'content')->textarea();

echo \yii\bootstrap\Html::submitButton("提交");


\yii\bootstrap\ActiveForm::end();