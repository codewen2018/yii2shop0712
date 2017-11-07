<?php
/**
 * @var $this \yii\web\View
 */
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model, 'name');
echo $form->field($model, 'parent_id')->dropDownList($cates);
echo $form->field($model, 'intro')->textarea();
echo \yii\bootstrap\Html::submitButton("提交", ['class' => 'btn btn-success']);
\yii\bootstrap\ActiveForm::end();
?>






